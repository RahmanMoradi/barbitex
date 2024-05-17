<?php

namespace App\Http\Middleware\Vip;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::check() && request()->user()->vip && request()->user()->vip->expire_at > Carbon::now())
            return $next($request);
        else
            return redirect('panel/vip/buy');
    }
}
