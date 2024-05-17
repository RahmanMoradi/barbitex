<?php

namespace App\Services\TraitService;

use App\Livewire\Market\Seller;
use App\Models\Admin\Admin;
use App\Notifications\Admin\SendNotificationToAdmin;
use Illuminate\Support\Facades\Auth;

trait SendError
{
    public static function sendMessage(Admin $user, $error)
    {
        $user->notify(new SendNotificationToAdmin('Error', $error));
    }
}
