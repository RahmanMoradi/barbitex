<?php

namespace App\Console\Commands\User;

use App\Jobs\User\ResetDayBuyJob;
use Illuminate\Console\Command;

class resetDayBuy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:reset-day-buy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'reset day buy';

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
        ResetDayBuyJob::dispatchNow();
    }
}
