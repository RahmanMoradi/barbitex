<?php

namespace App\Http\Middleware\User;

use Closure;
use Illuminate\Http\Request;

class UserActive
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
            if ($request->expectsJson()) {
                return abort(403, __('Your kyc is not verified.'));
            } else {
                flash(__('Your kyc is not verified.'))->error()->important();
                return redirect('/panel/authentication/profile');
            }
        }

        return $next($request);
    }
}
