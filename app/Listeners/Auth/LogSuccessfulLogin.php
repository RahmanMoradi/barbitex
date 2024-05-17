<?php

namespace App\Listeners\Auth;

use App\Models\Webazin\Auth\AuthLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        if (Auth::id() !== null) {
            AuthLog::create([
                'user_id' => Auth::id(),
                'ip' => request()->ip(),
                'device' => request()->userAgent()
            ]);
        }
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
    }
}
