<?php

namespace App\Providers\Custom;

use App\Models\Webazin\Coinmarketcap\Coinmarketcap;
use App\Models\Webazin\Kucoin\Kucoin;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class ManualServiceProvider extends ServiceProvider
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
        App::bind('coinmarketcap', function () {
            return new Coinmarketcap();
        });
    }
}
