<?php

namespace App\Http\Controllers\panel;

use App\Helpers\Helper;
use App\Models\Balance\Balance;
use App\Models\Wallet;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Larabookir\Gateway\Exceptions\RetryException;
use Larabookir\Gateway\Gateway;

class WalletController extends Controller
{

    public function deposit($symbol)
    {
        return view('panel.wallet.deposit', compact('symbol'));
    }

    public function withdraw($symbol)
    {
        return view('panel.wallet.withdraw', compact('symbol'));
    }

    public function transactions()
    {
        return view('panel.wallet.transactions');
    }

    public function callback(Wallet $wallet)
    {
        if (!Auth::check()){
            Auth::loginUsingId($wallet->user_id);
        }
        if ($wallet->user_id != Auth::id()) {
            flash(Lang::get('illegal access'))->error()->important();

            return redirect(url('panel/wallet'));
        }
        try {
            $gateway = Gateway::verify();
            $trackingCode = $gateway->trackingCode();
            $refId = $gateway->refId();
            $cardNumber = $gateway->cardNumber();
            $wallet->update([
                'status' => 'done'
            ]);
            Balance::createUnique('IRT', Auth::user(), $wallet->price);
//            Notification::send( User::whereRole( 2 )->get() , new SendNotificationToAdmin( 'orderCreate' , $order->id ) );

            return redirect(url('panel/wallet/transactions'));
        } catch (\Exception $e) {
            $wallet->update([
                'status' => 'cancel'
            ]);
            flash($e->getMessage())->important()->error();

            return redirect(url('panel/wallet/transactions'));
        } catch (RetryException $e) {
            flash($e->getMessage())->important()->error();

            return redirect(url('panel/wallet/transactions'));
        }
    }

    public function redirectPm(Wallet $wallet)
    {
        return view('Webazin.perfectmoney.redirect', compact('wallet'));
    }

    public function callbackPm($hash)
    {
        $decrypt = Helper::decrypt($hash);
        $data = explode('|', $decrypt);
        $status = $data[0];
        $wallet = Wallet::find($data[1]);

        if ($status == 'success') {
            $wallet->update([
                'status' => 'done'
            ]);
            flash('operation completed successfully')->success();
        } else {
            $wallet->update([
                'status' => 'cancel'
            ]);
            flash('the operation failed')->error();
        }

        return redirect('/panel/wallet/transactions');
    }

    public function transfer()
    {
        return view('panel.wallet.transfer');
    }

    public function cartToCart()
    {
        return view('panel.wallet.cart_to_cart');
    }
}
