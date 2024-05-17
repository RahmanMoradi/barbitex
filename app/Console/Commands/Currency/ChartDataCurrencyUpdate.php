<?php

namespace App\Console\Commands\Currency;

use App\Models\Currency\Currency;
use Illuminate\Console\Command;
use PHPUnit\Exception;

class ChartDataCurrencyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:chart-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'currency chart data update';

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
        Currency::where('active', 1)->where('chart_data',null)->chunk(100, function ($currencies) {
            foreach ($currencies as $currency) {
                try {
                    $data = collect();
                    if ($currency->market === 'binance') {
                        $id = 'binance';
                    } elseif ($currency->market === 'kucoin') {
                        $id = 'kucoin';
                    } else {
                        $data->push(json_encode([]));
                        continue;
                    }

                    $symbol = $currency->symbol . '/USDT';

                    $exchange = '\\ccxt\\' . $id;
                    $exchange = new $exchange();

                    if ($currency->symbol === 'USDT') {
                        $data->push(json_encode([]));
                        continue;
                    }
                    $ohlcv = $exchange->fetch_ohlcv($symbol);

                    $trading_view = $exchange->convert_ohlcv_to_trading_view($ohlcv);

                    $restored_ohlcvs = collect($exchange->convert_trading_view_to_ohlcv($trading_view));
                    $restored_ohlcvs->reverse()->take(100)->map(function ($item) use ($data) {
                        $data->push($item[1]);
                    });

                    $currency->update([
                        'chart_data' => $data
                    ]);

                    sleep(60);
                } catch (Exception $exception) {
                    continue;
                }
            }
        });
    }
}
