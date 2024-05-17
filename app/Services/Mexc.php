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
use App\Models\Webazin\Mexc\Facede\Mexc as Api;
use App\Services\InterFaceService\Withdrawal;
use App\Services\TraitService\QrSaveTrait;
use App\Services\TraitService\SendNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class Mexc implements Withdrawal
{
    use QrSaveTrait, SendNotification;

    public static function withdraw(Wallet $wallet)
    {
        $qty = Helper::numberFormatPrecision(-($wallet->price), $wallet->currencyRelation->decimal_size);
        try {
            $params = [
                'currency' => $wallet->currencyRelation->symbol,
                'chain' => $wallet->network->isDefault ? '' : $wallet->network->network,
                'amount' => $qty,
                'address' => $wallet->wallet,
                'memo' => $wallet->tag ?: '',
            ];

            $waithdraw = Api::post_asset_withdraw($params);

            if (isset($waithdraw['withdrawId'])) {
                $wallet->update([
                    'status' => 'done',
                    'service_id' => $waithdraw['withdrawId']
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
        $deposits = Api::get_asset_deposit_list(['currency' => $currency->symbol, 'status' => 'SUCCESS']);
        $deposits = collect($deposits['result_list']);
        foreach ($deposits as $deposit) {
            $deposit = collect($deposit);
            $deposit['txid'] = substr($deposit['txid'], 0, strpos($deposit['txid'], "@"));
            $has = $deposit['txid'] == $txidRequest;
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
        return null;
    }

    public function createNetworkList(Currency $currency)
    {
        Network::where('coin', strtoupper($currency->symbol))->delete();
        try {
            $response = Api::get_market_coin_list(['currency' => strtoupper($currency->symbol)]);
            $dataCurrency = collect($response[0]['coins']);
            $chains = Api::get_asset_deposit_address_list([
                'currency' => strtoupper($currency->symbol)
            ]);
            $i = 0;
            foreach ($chains['chains'] as $network) {
                try {
                    $extraData = $dataCurrency->where('chain', $network['chain'])->first();
                    $memo = explode(':', $network['address']);

                    if (count($memo) > 1) {
                        $network['memo'] = $memo[1];
                    } else {
                        $network['memo'] = null;
                    }
                    $data = [
                        'network' => $network['chain'],
                        'name' => $network['chain'],
                        'addressRegex' => '',
                        'address' => $network['address'],
                        'tag' => $network['memo'],
                        'memoRegex' => '',
                        'withdrawFee' => $extraData['fee'],
                        'withdrawMin' => $extraData['withdraw_limit_min'],
                        'withdrawMax' => $extraData['withdraw_limit_max'],
                        'minConfirm' => $extraData['deposit_min_confirm'],
                        'unLockConfirm' => '0',
                        'isDefault' => $i == 0,
                    ];
                    Network::create($data + [
                            'coin' => strtoupper($currency->symbol),
                        ]);

                } catch (\Exception $exception) {
                    flash($exception->getMessage())->error();
                    continue;
                }
                $i++;
            }

            $this->qrCodeSave($currency);
        } catch (\Exception $exception) {
            flash($exception->getMessage())->error()->livewire(new Currencies());
        }
    }

    public function tradToCurrency($order)
    {
        try {
            $fee = $order->qty * 0.2 / 100;
            $symbol = $order->currency->symbol . "_USDT";
            $tickerInfo = Api::get_market_ticker(['symbol' => $symbol]);
            $price = $tickerInfo[0]['ask'];
            $params = [
                'client_order_id' => $order->id,
                'symbol' => $symbol,
                'price' => $price,
                'quantity' => Helper::numberFormatPrecision($order->qty, $order->currency->decimal_size),
                'trade_type' => $order->type == 'buy' ? 'BID' : 'ASK',
                'order_type' => 'LIMIT_ORDER',
            ];

            Api::post_order_place($params);
        } catch (\Exception $exception) {
            foreach (Admin::all() as $admin) {
                SendNotification::sendMessage($admin, $exception->getMessage() . '  ' . Lang::get('conversion error from usdt in order number', ['orderId' => $order->id]));
            }
        }
    }

    public function getLastPrice(Currency $currency)
    {

        if ($currency->symbol != 'USDT') {
            $tickerInfo = Api::get_market_ticker(['symbol' => $currency->symbol . '_USDT']);

            $currency->update([
                'price' => $tickerInfo[0]['last'],
                'percent' => Helper::numberFormatPrecision((($tickerInfo[0]['last'] * 100) / $tickerInfo[0]['open']) - 100, 2)
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
        return false;
    }

    public function createOrderMarket($symbol, $funds, $type)
    {
        return null;
    }

    public function checkActive(MarketOrder $order)
    {
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
        $deposits = Api::get_asset_deposit_list(['currency' => $currency->symbol, 'status' => 'SUCCESS']);
        $deposits = collect($deposits['result_list']);
        foreach ($deposits as $deposit) {
            $deposit = collect($deposit);
            $deposit['txid'] = substr($deposit['txid'], 0, strpos($deposit['txid'], "@"));
            $txid = DB::table('txids')->where('txid', $deposit['txid'])->first();
            if (!$txid) {
                Helper::AddTxidToDb($deposit['txid'], $currency->symbol);
            }
        }
    }

    public function setTxid(Wallet $wallet)
    {
        $withdraw = Api::get_asset_withdraw_list(['currency' => $wallet->currency, 'withdraw_id' => $wallet->service_id]);

        if ($withdraw) {
            if (isset($withdraw['txid'])) {
                $wallet->update([
                    'txid' => $withdraw['txid']
                ]);
            } else {
                SetTxidJob::dispatch($wallet)->delay(Carbon::now()->addMinutes(2));
            }
        }
    }
}
