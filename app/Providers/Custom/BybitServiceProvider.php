<?php

namespace App\Providers\Custom;

use App\Models\Webazin\Bybit\Bybit;
use App\Models\Webazin\Kucoin\Kucoin;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class BybitServiceProvider extends ServiceProvider
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
        App::bind('bybit', function () {
            return new Bybit();
        });
    }
}
