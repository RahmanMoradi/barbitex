<?php

namespace App\Providers;

use anlutro\LaravelSettings\Facades\Setting;
use App\Models\Admin\Admin;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Validation\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        if (env('DEMO') == true){
            if (request()->is('wa-admin') || request()->is('wa-admin/*')) {
                Auth::guard('admin')->loginUsingId(2);
            }
            if (request()->is('panel') || request()->is('panel/*')) {
                Auth::loginUsingId(1);
            }
        }
    }
}
