<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class isCodeSetApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_code_set) {
            return $next($request);
        } else {
            return response(
                [
                    'code' => 0,
                    'data' => [],
                    'message' => Lang::get('enter email code')
                ]
            );
        }
    }
}
