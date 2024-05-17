<?php

namespace App\Jobs\User;

use App\Models\Balance\Balance;
use App\Models\Currency\Currency;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BalanceTableCreate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->onConnection('redis');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Balance::createUnique('IRT', $this->user, 0);
        Currency::orderBy('id')->chunk(100, function ($currencies) {
            foreach ($currencies as $currency) {
                Balance::createUnique($currency->symbol, $this->user, 0);
            }
        });
    }
}
