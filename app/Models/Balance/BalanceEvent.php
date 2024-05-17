<?php

namespace App\Models\Balance;

use App\Events\Market\BalanceUpdateEvent;
use App\Helpers\Helper;
use App\Models\Currency\Currency;

trait BalanceEvent
{
    public static function boot()
    {
        parent::boot();
        static::updated(function ($balance) {
            BalanceUpdateEvent::dispatch($balance->user_id, null, $balance->currency);
        });
    }
}
