<?php


namespace App\Models\Webazin\Binance\Facades;


use Illuminate\Support\Facades\Facade;

class Binance extends Facade {
    protected static function getFacadeAccessor() {
        return 'binance';
    }
}
