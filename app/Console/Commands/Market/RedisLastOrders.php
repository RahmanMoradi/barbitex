<?php

namespace App\Console\Commands\Market;

use App\Events\Binance\GetLastOrdersEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class RedisLastOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'market:redis-last-orders-subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'subscribe to last orders on redis';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Redis::psubscribe(['last-orders-subscribe-*'], function ($message, $channel) {
            $trades = json_decode($message);
            $symbol = $trades->symbol;

//            Cache::put($symbol . '-lastOrders', $trades);
            if (rand(0, 20) == 2) {
                event(new GetLastOrdersEvent($symbol, $trades));
            }
        });

    }
}
