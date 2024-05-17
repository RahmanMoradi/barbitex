<?php

namespace App\Console\Commands\Market;

use App\Events\Binance\GetNewAskFromBinance;
use App\Helpers\Helper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class RedisAskSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'market:redis-ask-subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe the ask bid redis channel';

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
        Redis::connection('subscriber')->psubscribe(['ask-subscribe-*'], function ($message, $channel) {
            $data = json_decode($message);
            $data = (object)$data;
            if (isset($data->asks)) {
                $asks = collect((array)$data->asks);
                $asks = $asks->take(19);
                $maxAsks = $asks->max();
                foreach ($asks as $key => $item) {
                    $asks[$key] = [Helper::numberFormatPrecision($asks[$key]), $asks[$key] * 100 / $maxAsks];
                }
                $asks = $asks->sortKeys();
                if (rand(0, 10) == 2) {
                    event(new GetNewAskFromBinance($data->symbol, $asks, null));
                }
            }
//            Cache::put($data->symbol . '-bids', $bids);
//            Cache::put($data->symbol . '-asks', $asks);
        });
    }
}
