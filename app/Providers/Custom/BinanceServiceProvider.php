<?php

namespace App\Providers\Custom;

use Binance\API;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class BinanceServiceProvider extends ServiceProvider
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

        App::bind('binance', function () {
            $api = new Api(config('webazin.binance.api_key'), config('webazin.binance.secret_key'), false);
            $api->caOverride = true;
            return $api;
        });
    }
}
