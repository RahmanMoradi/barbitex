<?php

namespace App\Services;


use App\Events\Currency\UpdatePrice;
use App\Events\Market\BalanceUpdateEvent;
use App\Helpers\Helper;
use App\Jobs\Currency\CurrencyUpdateWallet;
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
use App\Models\Webazin\Binance\Facades\Binance as Api;
use App\Services\InterFaceService\Withdrawal;
use App\Services\TraitService\QrSaveTrait;
use App\Services\TraitService\SendNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class Binance implements Withdrawal
{
    use QrSaveTrait;

    public static function withdraw(Wallet $wallet)
    {
        try {
            $qty = Helper::numberFormatPrecision($wallet->price - $wallet->network->withdrawFee, $wallet->currencyRelation->decimal_size);

            $response = Api::withdraw($wallet->currencyRelation->symbol, $wallet->wallet, $qty, $wallet->tag ?: "", false, $wallet->network->network, $wallet->id);

            if (isset($response['id'])) {
                $wallet->update([
                    'status' => 'done',
                    'description' => $response['id'],
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
                'status' => 'new',
                'description' => $exception->getMessage(),
            ]);

            flash(Lang::get('the operation failed') . ' ' . $exception->getMessage())->error()->important();
        }
    }

    /**
     * @param $txidRequest
     * @return array|void
     */
    public static function checkDeposit(Currency $currency, $txidRequest)
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
        Api::useServerTime();
        $deposit = collect(Api::depositHistory($currency->symbol, ['status' => 1]))
            ->whereIn('txId', [strtoupper($txidRequest), $txidRequest])
            ->first();

        if ($deposit) {
            Helper::AddTxidToDb($txidRequest, $currency->symbol);
            $amount = $deposit['amount'];
            return [
                'amount' => $amount,
                'status' => 1
            ];
        } else {
            return [
                'amount' => $amount,
                'status' => 0
            ];
        }
    }

    public function createOrder($symbol, $count, $price, $type)
    {
        try {
            if ($type == 'buy') {
                $orderInMarket = Api::buy($symbol, $count, $price);
            } else {
                $orderInMarket = Api::sell($symbol, $count, $price);
            }

            BalanceUpdateEvent::dispatch(Auth::check() ? Auth::id() : Auth::guard('api')->id(), Market::whereSymbol($symbol)->first(), null);
            return $orderInMarket;
        } catch (\Exception $exception) {
            foreach (Admin::all() as $admin) {
                SendNotification::sendMessage($admin, $exception->getMessage() . "symbol: $symbol Size: $count price: $price");
            }
            return null;
        }

    }

    public function createNetworkList(Currency $currency)
    {
        Network::where('coin', strtoupper($currency->symbol))->delete();
        try {
            $response = collect(Api::coins());
            $networkList = $response->where('coin', strtoupper($currency->symbol))->first();

            if (isset($networkList['networkList'])) {
                foreach ($networkList['networkList'] as $network) {
                    try {
                        $response = Api::depositAddress($currency->symbol, $network['network']);

                        Network::create($network + [
                                'coin' => strtoupper($currency->symbol),
                                'address' => $response['address'],
                                'tag' => $response['tag'] ?: null
                            ]);
                    } catch (\Exception $exception) {
                        continue;
                    }
                }
            }
            $this->qrCodeSave($currency);
        } catch (\Exception $exception) {
            foreach (Admin::all() as $admin) {
                SendNotification::sendMessage($admin, $exception->getMessage());
            }
            flash($exception->getMessage())->error();
        }
    }

    public function tradToCurrency(Order $order)
    {
        try {
            $symbol = $order->currency->symbol . "USDT";
            $qty = Helper::numberFormatPrecision($order->qty, $order->currency->decimal_size);
            if ($order->type == 'buy') {
                Api::marketBuy($symbol, $qty);
            } else {
                Api::marketSell($symbol, $qty);
            }

        } catch (\Exception $exception) {
            foreach (Admin::all() as $admin) {
                SendNotification::sendMessage($admin, $exception->getMessage() . '  ' . Lang::get('conversion error from usdt in order number', ['orderId' => $order->id]));
            }
        }
    }

    public function getLastPrice(Currency $currency)
    {
        if ($currency->symbol != 'USDT') {
            $ticker = Api::prevDay($currency->symbol . "USDT");
            $currency->update([
                'price' => $ticker['lastPrice'],
                'percent' => $ticker['priceChangePercent']
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
        try {
            return DB::transaction(function () use ($order) {
                if ($this->checkActive($order)) {
                    $response = Api::cancel($order->market->symbol, $order->market_order_id);
                    if (isset($response) && $response['status'] == 'CANCELED') {
                        $order->update([
                            'status' => 'cancel',
                        ]);
                        if ($order->type == 'sell') {
                            $currency = Currency::findOrFail($order->market->currency_buy);
                            $balanceOne = Balance::where('user_id', $order->user_id)->where('currency', $currency->symbol)->first();
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
            });
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function createOrderMarket($symbol, $funds, $type)
    {
        try {
            if ($type == 'buy') {
                $orderInMarket = Api::marketQuoteBuy($symbol, $funds);
            } else {
                $orderInMarket = Api::marketSell($symbol, $funds);
            }
            $orderInMarket['price'] = $orderInMarket['fills'][0]['price'];
            $orderInMarket['size'] = $orderInMarket['origQty'];
            BalanceUpdateEvent::dispatch(Auth::check() ? Auth::id() : Auth::guard('api')->id(), Market::whereSymbol($symbol)->first(), null);
            return $orderInMarket;
        } catch (\Exception $exception) {
            foreach (Admin::all() as $admin) {
                SendNotification::sendMessage($admin, $exception->getMessage() . "symbol: $symbol founds: $funds type: $type");
            }
            return null;
        }
    }

    public function checkActive(MarketOrder $order)
    {
        $orderstatus = Api::orderStatus($order->market->symbol, $order->market_order_id);
        if (isset($orderstatus) && $orderstatus['status'] == 'NEW') {
            return true;
        }
        return false;
    }

    public function setDecimalSize(Currency $currency)
    {
        $decimal = Api::exchangeInfo()['symbols']['KNC' . 'USDT'];
        $currency->update([
            'decimal_size' => $decimal['precision'] ?? $currency->decimal
        ]);
    }

    public function burnTxids(Currency $currency)
    {
        $deposits = collect(Api::depositHistory($currency->symbol, ['status' => 1]));

        foreach ($deposits as $deposit) {
            $txid = DB::table('txids')->where('txid', $deposit['txId'])->first();
            if (!$txid) {
                Helper::AddTxidToDb($deposit['txId'], $currency->symbol);
            }
        }
    }

    public function setTxid(Wallet $wallet)
    {
        $list = Api::fetch_withdrawals($wallet->currency);
        $list = collect($list);

        $withdraw = $list->where('id', $wallet->service_id)->first();
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
