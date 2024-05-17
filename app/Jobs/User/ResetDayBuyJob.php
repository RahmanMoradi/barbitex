<?php

namespace App\Jobs\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ResetDayBuyJob implements ShouldQueue {
    use Dispatchable , InteractsWithQueue , Queueable , SerializesModels ;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $users = User::where( 'day_buy' , '>' , 0 )->get();
        foreach ( $users as $user ) {
            $user->update( [
                'day_buy' => 0
            ] );
        }
    }
}
