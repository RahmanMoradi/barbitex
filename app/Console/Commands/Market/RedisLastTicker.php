<?php

namespace App\Console\Commands\Market;

use App\Events\Binance\GetTicker;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class RedisLastTicker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'market:redis-last-ticker-subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'redis last ticker subscribe';

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
        Redis::psubscribe(['last-ticker-subscribe-*'], function ($message) {
            $data = json_decode($message);
            $data = collect($data);
//            dd($data);
//            $symbol = str_replace('-', '', $data['symbol']);
            $percent = !isset($data['percentChange']) ? number_format((($data['lastTradedPrice'] * 100) / ($data['lastTradedPrice'] - ($data['changePrice'])) - 100), 2) : 0;
//            $percent = !isset($data['percentChange']) ? $data['changePrice'] : 0;
            $ticker = collect([
                'symbol' => $data['symbol'],
                'high' => $data['high'],
                'low' => $data['low'],
                'close' => isset($data['close']) ? $data['close'] : $data['last'],
                'volume' => isset($data['volume']) ? $data['volume'] : $data['volValue'],
                'percentChange' => isset($data['percentChange']) ? $data['percentChange'] : $percent,
            ]);
//            Cache::put($symbol . '-ticker', $ticker);
//            if (rand(0, 5) == 2) {
                event(new GetTicker($data['symbol'], $ticker));
//            }
        });
    }
}
