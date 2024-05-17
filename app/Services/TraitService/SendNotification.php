<?php

namespace App\Services\TraitService;

use App\Livewire\Market\Seller;
use App\Models\Admin\Admin;
use App\Notifications\Admin\SendNotificationToAdmin;
use Illuminate\Support\Facades\Auth;

trait SendNotification
{
    public static function sendMessage(Admin $user, $text, $type = 'error')
    {
        $type == 'error' ?
            $user->notify(new SendNotificationToAdmin('Error', $text)) :
            $user->notify(new SendNotificationToAdmin('Message', $text));

    }
}
