<?php

namespace App\Http\Middleware\User;

use Closure;
use Illuminate\Http\Request;

class CardActive
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
            if ($request->expectsJson()) {
                return abort(403, __('Your Card is not verified.'));
            } else {
                flash(__('Your Card is not verified.'))->error()->important();
                return redirect('/panel/authentication/card');
            }
        }

        return $next($request);
    }
}
