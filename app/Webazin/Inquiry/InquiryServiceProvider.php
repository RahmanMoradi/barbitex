<?php

namespace App\Webazin\Inquiry;

use App\Webazin\Jibit\Facade\JibitFacade;
use App\Webazin\Jibit\Service\JibitService;
use App\Webazin\Nextpay\Service\NextpayService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class InquiryServiceProvider extends ServiceProvider
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
        App::bind('Inquiry', function () {
            return match (config('webazin.inquiry.default')) {
                'nextpay' => new NextpayService(),
                default => new JibitService()
            };
        });
    }
}
