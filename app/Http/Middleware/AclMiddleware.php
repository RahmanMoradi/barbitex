<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class AclMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('admin.login');
        }
        if (Auth::guard('admin')->user()->roles->count() > 0 && Auth::guard('admin')->user()->roles[0]->permissions->contains('name', $roles[0])) {
            return $next($request);
        }
        flash(Lang::get('illegal access'))->error()->important();

        return back();
    }
}
