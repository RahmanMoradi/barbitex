<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class UserActiveApi
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !$request->user()->hasVerifiedDoc()) {
            return response(
                [
                    'code' => 0,
                    'data' => [],
                    'message' => Lang::get('you have not yet verified')
                ]
            );
        } else {
            return $next($request);
        }
    }
}
