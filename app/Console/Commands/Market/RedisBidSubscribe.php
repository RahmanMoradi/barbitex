<?php

namespace App\Console\Commands\Market;

use App\Events\Binance\GetNewAskFromBinance;
use App\Helpers\Helper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class RedisBidSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'market:redis-bid-subscribe';

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
        Redis::psubscribe(['bid-subscribe-*'], function ($message, $channel) {
            $data = json_decode($message);
            $data = (object)$data;

            if (isset($data->bids)) {
                $bids = collect((array)$data->bids);
                $bids = $bids->take(19);

                $maxBids = $bids->max();

                foreach ($bids as $key => $item) {
                    $bids[$key] = [Helper::numberFormatPrecision($bids[$key]), $bids[$key] * 100 / $maxBids];
                }
                $bids = $bids->sortKeys();
                if (rand(0, 10) == 2) {
                    broadcast(new GetNewAskFromBinance($data->symbol, null, $bids));
                }

            }
//            Cache::put($data->symbol . '-bids', $bids);
//            Cache::put($data->symbol . '-asks', $asks);
        });
    }
}
