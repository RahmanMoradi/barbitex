<?php

namespace App\Jobs\Currency;

use App\Models\Balance\Balance;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BalanceTableCreateForUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $symbol;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($symbol)
    {
        $this->symbol = $symbol;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        User::orderBy('id')->chunk(100, function ($users) {
            foreach ($users as $user) {
                Balance::createUnique($this->symbol, $user, 0);
            }
        });
    }
}
