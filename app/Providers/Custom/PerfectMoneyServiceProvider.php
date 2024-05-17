<?php

namespace App\Providers\Custom;

use App\Models\Webazin\PerfectMoney\PerfectMoney;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class PerfectMoneyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        App::bind('perfectmoney', function () {
            return new PerfectMoney();
        });
    }
}
