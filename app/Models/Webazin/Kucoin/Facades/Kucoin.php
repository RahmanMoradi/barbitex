<?php


namespace App\Models\Webazin\Kucoin\Facades;


use Illuminate\Support\Facades\Facade;

class Kucoin extends Facade {
    protected static function getFacadeAccessor() {
        return 'kucoin';
    }
}
