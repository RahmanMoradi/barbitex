<?php

namespace App\Http\Middleware\Api;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class IsVip
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
        if (Auth::guard('api')->check() && Auth::guard('api')->user()->vip && Auth::guard('api')->user()->vip->expire_at > Carbon::now())
            return $next($request);
        else
            return response(
                [
                    'code' => 0,
                    'data' => [],
                    'message' => Lang::get('you do not have permission to enter the vip section. create a vip subscription')
                ]
            );
    }
}
