<?php

namespace App\Webazin\Inquiry;

use Illuminate\Support\Facades\Facade;

class Inquiry extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Inquiry';
    }
}
