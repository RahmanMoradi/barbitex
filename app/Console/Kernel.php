<?php

namespace App\Console;

use App\Console\Commands\Currency\ChartDataCurrencyUpdate;
use App\Console\Commands\getPriceFromService;
use App\Console\Commands\Market\GetLastTickerPrice;
use App\Console\Commands\Market\RedisAskBidSubscribe;
use App\Console\Commands\Market\RedisLastOrders;
use App\Console\Commands\Market\RedisLastTicker;
use App\Console\Commands\Market\RedisOrderUpdate;
use App\Console\Commands\Market\RunGetMarketAskBid;
use App\Console\Commands\RunProject;
use App\Console\Commands\User\resetDayBuy;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        RedisLastOrders::class,
        RedisLastTicker::class,
        RedisOrderUpdate::class,
        getPriceFromService::class,
        resetDayBuy::class,
        ChartDataCurrencyUpdate::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('user:reset-day-buy')->dailyAt('23:59');
        $schedule->command('currency:chart-data')->everySixHours();
//        $schedule->command('market:redis-order-update')->everyMinute();
//        $schedule->command('binance:redis-last-orders-subscribe');
//        $schedule->command('binance:redis-last-ticker-subscribe');
//        $schedule->command('binance:markets-getOrders');
//        $schedule->command('binance:get-last-order')->everyMinute();
//        $schedule->command('binance:redis-ask-bid-subscribe')->everyMinute();
//        $schedule->command('binance:ticker-update')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
