<?php

namespace App\Providers\Custom;

use App\Models\Webazin\Kucoin\Kucoin;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class KucoinServiceProvider extends ServiceProvider
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
        App::bind('kucoin', function () {
            return new Kucoin();
        });
    }
}
