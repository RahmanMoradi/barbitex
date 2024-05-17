<?php

namespace App\Models\Card;

use App\Models\Admin\Admin;
use App\Models\User;
use App\Models\Wallet;
use App\Notifications\Admin\SendNotificationToAdmin;
use App\Notifications\User\SendNotificationToUsers;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;

trait CardEvent
{
    protected static function boot()
    {
        parent::boot();
        Card::created(function ($card) {
            $userEmail = User::find($card->user_id)->email;
            Notification::send(Admin::all(),
                new SendNotificationToAdmin(Lang::get('bank card'), Lang::get('the new bank card was registered by', ['email' => $userEmail]), Lang::get('list of bank cards'),
                    url('wa-admin/cards'), "adminCardCreate", $userEmail));
        });

        Card::updated(function ($card) {
            $userEmail = User::find($card->user_id)->email;
            Notification::send(User::find($card->user_id),
                new SendNotificationToUsers(Lang::get('bank card'),
                    Lang::get('your card was changed in the system',['cardNumber'=>$card->card_number,'status' => $card->status_text]),
                    Lang::get('list of bank cards'), url('panel/authentication/card'), 'approve', $userEmail, Lang::get('bank card'), $card->status_text));
        });
    }
}
