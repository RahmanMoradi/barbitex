<?php


namespace App\Models\Webazin\Mexc\Facede;


use Illuminate\Support\Facades\Facade;

class Mexc extends Facade {
    protected static function getFacadeAccessor() {
        return 'mexc';
    }
}
