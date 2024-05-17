<?php

namespace App\Models\User;

use App\Jobs\User\BalanceTableCreate;
use App\Models\Admin\Admin;
use App\Models\User;
use App\Notifications\Admin\SendNotificationToAdmin;
use App\Notifications\User\SendNotificationToUsers;
use Illuminate\Support\Facades\Notification;

trait UserEvent
{
    protected static function boot()
    {
        parent::boot();
        static::created(function ($user) {
            BalanceTableCreate::dispatchNow($user);
        });
    }
}
