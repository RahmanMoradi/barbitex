<?php

namespace App\Models\Webazin\Gateio\Facade;

use Illuminate\Support\Facades\Facade;

class GateioFacade extends Facade
{
    protected static function getFacadeAccessor() {
        return 'gateio';
    }
}
