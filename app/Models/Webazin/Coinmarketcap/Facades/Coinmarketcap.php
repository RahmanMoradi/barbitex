<?php


namespace App\Models\Webazin\Coinmarketcap\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * @method static getLastPrice($params)
 *  *
 */
class Coinmarketcap extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'coinmarketcap';
    }
}
