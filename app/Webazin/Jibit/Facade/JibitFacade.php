<?php

namespace App\Webazin\Jibit\Facade;

use Illuminate\Support\Facades\Facade;

class JibitFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Jibit';
    }
}
