<?php

namespace App\Webazin\Jibit\Provider;

use App\Webazin\Jibit\Service\JibitService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class JibitServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        App::bind('Jibit', function () {
            return new JibitService();
        });
    }
}
