<?php

namespace App\Jobs\User\Login;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class setIsCodeUser implements ShouldQueue {
    use Dispatchable , InteractsWithQueue , Queueable , SerializesModels;

    public $user;
    public $type;

    /**
     * Create a new job instance.
     *
     * @param                $type
     */
    public function __construct( $user , $type ) {
        $this->user = $user;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $this->user->update( [
            'is_code_set'   => $this->type ,
        ] );
    }
}
