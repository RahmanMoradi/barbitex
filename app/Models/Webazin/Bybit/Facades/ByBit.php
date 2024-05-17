<?php

namespace App\Models\Webazin\Bybit\Facades;

use Illuminate\Support\Facades\Facade;

class ByBit extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'bybit';
    }
}
