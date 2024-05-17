<?php

namespace App\Services;

use App\Models\Admin\Admin;
use App\Models\Currency\Currency;
use App\Models\Order\Order;
use App\Models\Traid\Market\MarketOrder;
use App\Models\Wallet;
use \App\Models\Webazin\PerfectMoney\PerfectMoney as Api;
use App\Services\InterFaceService\Withdrawal;
use App\Services\TraitService\SendNotification;
use Illuminate\Support\Facades\Lang;

class PerfectMoney implements Withdrawal
{

    public static function withdraw(Wallet $wallet)
    {
        $api = new Api();
        $amount = str_replace('-', '', $wallet->price);
        if ($wallet->service_id == 'perfectmoney') {
            try {
                $withdraw = $api->sendMoney($wallet->wallet, $amount, ' ', $wallet->id);
                if ($withdraw['status'] == 'success') {
                    $wallet->update([
                        'status' => 'done',
                    ]);
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
                dd($exception->getMessage());
                flash(Lang::get('the operation failed') . ' ' . $exception->getMessage())->error()->important();
            }
        } else {
            try {
                $voucher = $api->createVoucher(config('webazin.perfectmoney.merchant_id'), $amount);
                if (isset($voucher['VOUCHER_NUM'])) {
                    $wallet->update([
                        'status' => 'done',
                        'description' => 'voucher num: ' . $voucher['VOUCHER_NUM'] . '\n' . 'voucher code: ' . $voucher['VOUCHER_CODE']
                    ]);
                    if ($wallet->admin_id == 0) {
                        foreach (Admin::all() as $admin) {
                            SendNotification::sendMessage($admin, Lang::get('request for deposit of order number was made', ['walletId' => $wallet->id]), 'message');
                        }
                    } else {
                        $admin = Admin::find($wallet->admin_id);
                        SendNotification::sendMessage($admin, Lang::get('request for deposit of order number was made', ['walletId' => $wallet->id]), 'message');
                    }
                } else {
                    if ($wallet->admin_id == 0) {
                        foreach (Admin::all() as $admin) {
                            SendNotification::sendMessage($admin, Lang::get(Lang::get('the operation failed') . ' ' . $voucher['ERROR']), 'error');
                        }
                    } else {
                        $admin = Admin::find($wallet->admin_id);
                        SendNotification::sendMessage($admin, Lang::get(Lang::get('the operation failed') . ' ' . $voucher['ERROR']), 'error');
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
                dd($exception->getMessage());
                flash(Lang::get('the operation failed') . ' ' . $exception->getMessage())->error()->important();
            }
        }
    }

    public static function checkDeposit(Currency $currency, $txid)
    {
        // TODO: Implement checkDeposit() method.
    }

    public function createOrder($symbol, $count, $price, $type)
    {
        // TODO: Implement createOrder() method.
    }

    public function createOrderMarket($symbol, $funds, $type)
    {
        // TODO: Implement createOrderMarket() method.
    }

    public function createNetworkList(Currency $currency)
    {
        // TODO: Implement createNetworkList() method.
    }

    public function tradToCurrency(Order $order)
    {
        // TODO: Implement tradToCurrency() method.
    }

    public function getLastPrice(Currency $currency)
    {
        $currency->update([
            'price' => 1,
        ]);
    }

    public function cancelOrder(MarketOrder $order)
    {
        // TODO: Implement cancelOrder() method.
    }

    public function checkActive(MarketOrder $order)
    {
        // TODO: Implement checkActive() method.
    }

    public function burnTxids(Currency $currency)
    {
        // TODO: Implement burnTxids() method.
    }

    public function setTxid(Wallet $wallet)
    {
        // TODO: Implement setTxid() method.
    }
}
