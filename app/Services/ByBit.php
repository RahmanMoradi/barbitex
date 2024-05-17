<?php

namespace App\Services;

use App\Events\Currency\UpdatePrice;
use App\Events\Market\BalanceUpdateEvent;
use App\Helpers\Helper;
use App\Jobs\Currency\CreateNetworkList;
use App\Jobs\Wallet\SetTxidJob;
use App\Livewire\Admin\Currency\Currencies;
use App\Models\Admin\Admin;
use App\Models\Balance\Balance;
use App\Models\Currency\Currency;
use App\Models\Network\Network;
use App\Models\Order\Order;
use App\Models\Traid\Market\Market;
use App\Models\Traid\Market\MarketOrder;
use App\Models\Wallet;
use App\Models\Webazin\ByBit\Facades\ByBit as Api;
use App\Services\InterFaceService\Withdrawal;
use App\Services\TraitService\QrSaveTrait;
use App\Services\TraitService\SendNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class ByBit implements Withdrawal
{
    use QrSaveTrait, SendNotification;

    public static function withdraw(Wallet $wallet)
    {
        $qty = Helper::numberFormatPrecision(-($wallet->price), $wallet->currencyRelation->decimal_size);
        try {
            $params = [
                'clientOid' => $wallet->id,
                'coin' => $wallet->currencyRelation->symbol,
                'chain' => $wallet->network->isDefault ? '' : $wallet->network->network,
                'address' => $wallet->wallet,
                'tag' => $wallet->tag ?: '',
                'amount' => $qty,
                'timestamp' => Carbon::now()->timestamp,
            ];
            $waithdraw = Api::account()->withdraw($params);
            if (isset($waithdraw['result']['id'])) {
                $wallet->update([
                    'status' => 'done',
                    'service_id' => $waithdraw['result']['id']
                ]);
                SetTxidJob::dispatch($wallet)->delay(Carbon::now()->addMinutes(2));
                if ($wallet->admin_id == 0) {
                    foreach (Admin::all() as $admin) {
                        SendNotification::sendMessage($admin, Lang::get('request for deposit of order number was made', ['walletId' => $wallet->id]), 'message');
                    }
                } else {
                    $admin = Admin::find($wallet->admin_id);
                    SendNotification::sendMessage($admin, Lang::get('request for deposit of order number was made', ['walletId' => $wallet->id]), 'message');

                }
            }
        } catch (\Exception $exception) {
            $wallet->update([
                'description' => $wallet->desccription . ' --- ' . $exception->getMessage()
            ]);
            if ($wallet->admin_id == 0) {
                foreach (Admin::all() as $admin) {
                    SendNotification::sendMessage($admin, $exception->getMessage());
                }
            } else {
                SendNotification::sendMessage(Admin::find($wallet->admin_id), $exception->getMessage());
            }
            flash(Lang::get('the operation failed') . ' ' . $exception->getMessage())->error()->important();
        }
    }

    public static function checkDeposit($currency, $txidRequest)
    {
        $amount = 0;
        $txid = DB::table('txids')->where('txid', $txidRequest)->first();
        if ($txid) {
            return [
                'amount' => $amount,
                'status' => 0,
                'error' => Lang::get('this transaction has already been registered')
            ];
        }
        $deposits = Api::account()->getDeposits(['coin' => $currency->symbol]);
        $deposits = collect($deposits['rows']);
        foreach ($deposits as $deposit) {
            $deposit = collect($deposit);
            $has = $deposit['txID'] == $txidRequest;
            if ($has) {
                Helper::AddTxidToDb($txidRequest, $currency->symbol);

                $amount = $deposit['amount'];
                return [
                    'amount' => $amount,
                    'status' => 1
                ];
            }
        }
        return [
            'amount' => $amount,
            'status' => 0
        ];
    }

    public function createOrder($symbol, $count, $price, $type)
    {
        $currencySymbol = explode('-', $symbol)[0];
        $currency = Currency::whereSymbol($currencySymbol)->first();
        try {
            $params = [
                'orderLinkId' => uniqid('', true),
                'side' => strtoupper($type),
                'symbol' => str_replace('-', '', $symbol),
                'orderType' => 'LIMIT',
                'orderQty' => Helper::numberFormatPrecision($count, $currency->decimal_size),
                'orderPrice' => Helper::numberFormatPrecision($price, $currency->decimal_size),
            ];
            BalanceUpdateEvent::dispatch(Auth::check() ? Auth::id() : Auth::guard('api')->id(), Market::whereSymbol($symbol)->first(), null);
            return Api::spot()->postOrder($params);
        } catch (\Exception $exception) {
            foreach (Admin::all() as $admin) {
                SendNotification::sendMessage($admin, $exception->getMessage());
            }
            return null;
        }

    }

    public function createNetworkList(Currency $currency)
    {
        Network::where('coin', strtoupper($currency->symbol))->delete();
        try {
            $response = Api::account()->getAddresses($currency->symbol);
            $response = $response['result']['chains'];
            $i = 1;
            if (count($response) > 0) {
                foreach ($response as $network) {
                    try {

                        $detail = collect(Api::account()->getList([
                            'coin' => $response['coin'],
                            'chain' => $response['chain']
                        ])['result']['configList']);

                        $data = [
                            'network' => $network['chainType'],
                            'name' => $network['chainType'],
                            'addressRegex' => '',
                            'address' => $network['addressDeposit'],
                            'tag' => $network['tagDeposit'],
                            'memoRegex' => '',
                            'withdrawFee' => isset($detail['withdrawalMinFee']) ? $detail['withdrawalMinFee'] : '',
                            'withdrawMin' => isset($detail['withdrawalMinSize']) ? $detail['withdrawalMinSize'] : '',
                            'withdrawMax' => '',
                            'minConfirm' => $detail['blockConfirmNumber'],
                            'unLockConfirm' => '0',
                            'isDefault' => $i == 1,
                        ];
                        Network::create($data + [
                                'coin' => strtoupper($currency->symbol),
                            ]);
                        $i++;
                    } catch (\Exception $exception) {
                        flash($exception->getMessage())->error();
                        continue;
                    }
                }
            }
            $this->qrCodeSave($currency);
        } catch (\Exception $exception) {
            flash($exception->getMessage())->error()->livewire(new Currencies());
        }
    }

    public function tradToCurrency($order)
    {
        try {
            $symbol = $order->currency->symbol . "-USDT";
            $params = [
                'clientOid' => $order->id,
                'side' => $order->type,
                'symbol' => $symbol,
                'type' => 'market',
                'size' => Helper::numberFormatPrecision($order->qty, $order->currency->decimal_size),
            ];
            $markets = Api::symbol()->getList();
            $markets = collect($markets);
            if (!$markets->where('symbol', $symbol)->first()) {
                return;
            }
            Api::order()->create($params);
        } catch (\Exception $exception) {
            foreach (Admin::all() as $admin) {
                SendNotification::sendMessage($admin, $exception->getMessage() . '  ' . Lang::get('conversion error from usdt in order number', ['orderId' => $order->id]));
            }
        }
    }

    public function getLastPrice(Currency $currency)
    {

        if ($currency->symbol != 'USDT') {
            $tickers = Api::symbol()->getAllTickers();
            $tickers = collect($tickers['ticker']);
            $ticker = $tickers->where('symbol', "$currency->symbol-USDT")->first();
            $currency->update([
                'price' => $ticker['last'],
                'percent' => number_format($ticker['changePrice'] * 100 / $ticker['last'], 2)
            ]);
            event(new UpdatePrice($currency->symbol));
        } else {
            $currency->update([
                'price' => 1,
                'percent' => 0
            ]);
        }
    }

    public function cancelOrder(MarketOrder $order)
    {
        if ($this->checkActive($order)) {
            $cancel = Api::order()->cancel($order->market_order_id);
            if (isset($cancel['cancelledOrderIds']) && count($cancel['cancelledOrderIds']) > 0) {
                $order->update([
                    'status' => 'cancel',
                ]);
                if ($order->type == 'sell') {
                    $currency = Currency::findOrFail($order->market->currency_buy);
                    $balanceOne = \App\Models\Balance\Balance::where('user_id', $order->user_id)->where('currency', $currency->symbol)->first();
                    $balanceOne->update([
                        'balance_use' => $balanceOne->balance_use - ($order->count),
                        'balance_free' => $balanceOne->balance_free + ($order->count)
                    ]);
                } else {
                    $currency = Currency::findOrFail($order->market->currency_sell);
                    $balanceTwo = Balance::where('user_id', $order->user_id)->where('currency', $currency->symbol)->first();
                    $balanceTwo->update([
                        'balance_use' => $balanceTwo->balance_use - ($order->sumPrice),
                        'balance_free' => $balanceTwo->balance_free + ($order->sumPrice)
                    ]);
                }
                BalanceUpdateEvent::dispatch($order->user_id, $order->market, null);
                return true;
            }
        }
        return false;
    }

    public function createOrderMarket($symbol, $funds, $type)
    {
        $currencySymbol = explode('-', $symbol)[0];
        $currency = Currency::whereSymbol($currencySymbol)->first();
        try {
            $params = [
                'clientOid' => uniqid('', true),
                'side' => $type,
                'symbol' => $symbol,
                'type' => 'market',
            ];
            if ($type == 'buy') {
                $params = $params + [
                        'funds' => Helper::numberFormatPrecision($funds, 4),
                    ];
            } else {
                $params = $params + [
                        'size' => Helper::numberFormatPrecision($funds, $currency->decimal_size),
                    ];
            }
            $order = Api::order()->create($params);
            if (isset($order['orderId'])) {
                $detail = Api::order()->getDetail($order['orderId']);
                BalanceUpdateEvent::dispatch(Auth::check() ? Auth::id() : Auth::guard('api')->id(), Market::whereSymbol($symbol)->first(), null);
                return [
                    'orderId' => $detail['id'] ?: null,
                    'size' => $detail['dealSize'] ?: null,
                    'price' => $detail['dealSize'] ? ($detail['dealFunds'] / $detail['dealSize']) : null,
                ];
            }
        } catch (\Exception $exception) {
            foreach (Admin::all() as $admin) {
                SendNotification::sendMessage($admin, $exception->getMessage());
            }
            return null;
        }
    }

    public function checkActive(MarketOrder $order)
    {
        $orderStatus = Api::order()->getDetail($order->market_order_id);
        if ($orderStatus['isActive']) {
            return true;
        }
        return false;
    }

    public function setDecimalSize(Currency $currency)
    {
        $decimal = Api::currency()->getDetail($currency->symbol);
        dd($decimal);
        $currency->update([
            'decimal_size' => $decimal['precision'] ?? $currency->decimal
        ]);
    }

    public function burnTxids(Currency $currency)
    {
        $deposits = Api::deposit()->getDeposits(['currency' => $currency->symbol, 'status' => 'SUCCESS']);
        $deposits = collect($deposits['items']);
        foreach ($deposits as $deposit) {
            $deposit = collect($deposit);
            $deposit['walletTxId'] = substr($deposit['walletTxId'], 0, strpos($deposit['walletTxId'], "@"));
            $txid = DB::table('txids')->where('txid', $deposit['walletTxId'])->first();
            if (!$txid) {
                Helper::AddTxidToDb($deposit['walletTxId'], $currency->symbol);
            }
        }
    }

    public function setTxid(Wallet $wallet)
    {
        $list = Api::withdrawal()->getList(['currency' => $wallet->currency]);
        $list = collect($list['items']);
        $withdraw = $list->where('id', $wallet->service_id)->first();
        if ($withdraw) {
            if (isset($withdraw['walletTxId'])) {
                $wallet->update([
                    'txid' => $withdraw['walletTxId']
                ]);
            } else {
                SetTxidJob::dispatch($wallet)->delay(Carbon::now()->addMinutes(2));
            }
        }
    }
}
