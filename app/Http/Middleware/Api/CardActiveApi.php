<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class CardActiveApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !$request->user()->cardActive->count() > 0) {
            return response(
                [
                    'code' => 0,
                    'data' => [],
                    'message' => Lang::get('you must register your card')
                ]
            );

        } else {
            return $next( $request );
        }
    }
}
