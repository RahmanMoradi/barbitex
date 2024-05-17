<?php

namespace App\Models\Wallet;

use App\Models\Admin\Admin;
use App\Models\User;
use App\Models\Wallet;
use App\Notifications\Admin\SendNotificationToAdmin;
use App\Notifications\User\SendNotificationToUsers;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;

trait WalletEvent
{
    protected static function boot()
    {
        parent::boot();
        Wallet::updated(function ($wallet) {
            if ($wallet->status == 'done' && $wallet->type == 'decrement') {
                Notification::send(User::find($wallet->user_id),
                    new SendNotificationToUsers(Lang::get('deposit transaction'), Lang::get('your transaction has been confirmed and deposited'), Lang::get('list of transactions'),
                        url('panel/wallet/transactions'), "withdraw", $wallet->price));
            }
        });

        Wallet::created(function ($wallet) {
            if ($wallet->type == 'decrement') {
                Notification::send(Admin::all(),
                    new SendNotificationToAdmin(Lang::get('withdrawal request'), Lang::get('withdrawal request was registered', ['id' => $wallet->id]), Lang::get('list of transactions'),
                        url('wa-admin/wallet/decrement'), "adminWithdraw", $wallet->currency, $wallet->price));
            }
        });
    }
}
