<?php

namespace App\Providers;

use App\Events\Market\OrderPalcedEvent;
use App\Listeners\Auth\LogSuccessfulLogin;
use App\Listeners\Market\OrderPlacedListener;
use App\Listeners\MarketOrderPlacedListener;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderPalcedEvent::class => [
            OrderPlacedListener::class
        ],
        Login::class=>[
            LogSuccessfulLogin::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
