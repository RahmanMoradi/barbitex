<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Facade;

class HelperFacade extends Facade
{
    protected static function getFacadeAccessor() {
        return 'MyHelper';
    }
}
