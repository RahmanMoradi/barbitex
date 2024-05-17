<?php

namespace App\Console\Commands\Market;

use anlutro\LaravelSettings\Facade as Settings;
use App\Models\Balance\Balance;
use App\Models\Currency\Currency;
use App\Models\Traid\Market\MarketOrder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RedisOrderUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'market:redis-order-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'order Filled';

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
        Redis::psubscribe(['market-order-update'], function ($message) {
            if (!$message) {
                return;
            }
            $data = json_decode($message);
            $order = (object)$data;
            $order = (object)$order->order;
            sleep(5);
            if ($order->type == 'filled' || $order->status == 'FILLED') {
                $activeOrder = MarketOrder::where('market_order_id', $order->orderId)->first();

                if ($activeOrder && $activeOrder->status == 'init') {
                    $activeOrder->update([
                        'status' => 'done',
                        'remaining' => 0
                    ]);
                }
            }
        });
    }
}
