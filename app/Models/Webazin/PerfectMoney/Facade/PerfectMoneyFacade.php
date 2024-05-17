<?php


namespace App\Models\Webazin\PerfectMoney\Facade;


use Illuminate\Support\Facades\Facade;

class PerfectMoneyFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'perfectmoney';
    }
}
