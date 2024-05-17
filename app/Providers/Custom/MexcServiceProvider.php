<?php

namespace App\Providers\Custom;

use App\Models\Webazin\Mexc\Mexc;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class MexcServiceProvider extends ServiceProvider
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
        App::bind('mexc', function () {
            return new Mexc();
        });
    }
}
