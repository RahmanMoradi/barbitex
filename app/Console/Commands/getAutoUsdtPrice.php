<?php

namespace App\Console\Commands;

use anlutro\LaravelSettings\Facade as Setting;
use App\Models\User;
use App\Notifications\Admin\SendNotificationToAdmin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

class getAutoUsdtPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:getUsdtPrice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get Auto usdt Price';

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
        if (Setting::get('usdAutoUpdate')) {
            try {
                $response = Http::get('https://api.nobitex.ir/v2/trades/USDTIRT');
                $price = $response->json()['trades'][0]['price'];
                Setting::set([
                    'dollar_sell_pay' =>
                        number_format($price / 10, 0, '.', ''),
                    'dollar_buy_pay' =>
                        number_format($price / 10, 0, '.', ''),
                    'dollar_pay' => number_format($price / 10, 0, '.', '')
                ]);
                Setting::save();
            } catch (\Exception $exception) {
                //TODO Send notification to admin
            }
        }
    }
}
