<?php

namespace App\Console\Commands;

use App\Models\Currency\Currency;
use Illuminate\Console\Command;

class getPriceFromService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:getPrice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change Currency Price';

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
        Currency::where('active', 1)->where('type', 'coin')->chunk(100,function ($currencies){
            foreach ($currencies as $currency) {
                try {
                    $currency->service()->getLastPrice($currency);
                } catch
                (\Exception $exception) {
                    continue;
                }
            }
        });

    }
}
