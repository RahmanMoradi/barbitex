<?php

namespace App\Console\Commands\Market;

use App\Events\Binance\GetNewAskFromBinance;
use App\Helpers\Helper;
use App\Models\Traid\Market\Market;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redis;
use phpseclib\Net\SSH2;

class AddMarketsToRedis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'market:addToRedis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add markets to redis';

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
        $this->info('start');
        $kucoinMarkets = Market::where('market', 'kucoin')->where('status', 1)->pluck('symbol')->toArray();
        $binanceMarkets = Market::where('market', 'binance')->where('status', 1)->pluck('symbol')->toArray();
        $binanceList = [];
        foreach ($binanceMarkets as $market) {
            $binanceList[] = str_replace('-', '', $market);
        }
        Redis::set('binance_markets', json_encode($binanceList));
        Redis::set('kucoin_markets', json_encode($kucoinMarkets));

        $ssh = new SSH2(env('SSHIP'));
        if (!$ssh->login(env('SSHUSER'), env('SSHPASSWORD'))) {
            $this->error("no connect ssh");

        } else {
            $return_value1 = $ssh->exec('pm2 restart All');
            $return_value5 = $ssh->exec('supervisorctl restart markets:*');
        }
    }
}
