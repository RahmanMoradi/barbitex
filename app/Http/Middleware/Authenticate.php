<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Lang;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if ($request->is('wa-admin') || $request->is('wa-admin/*')) {
            return route('admin.login');
        }
        if (!$request->expectsJson()) {
            return route('login');
        }
        abort(response()->json(
            [
                'code' => 2,
                'data' => [],
                'message' => Lang::get('session expired'),
                'meta' => null,
                'type' => null
            ]));
    }
}
