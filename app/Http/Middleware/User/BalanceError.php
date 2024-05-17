<?php

namespace App\Http\Middleware\User;

use App\Helpers\Helper;
use App\Models\Balance\Balance;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class BalanceError
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $error = false;
            $balances = Balance::where('user_id', Auth::id())->get();
            foreach ($balances as $balance) {
                if (Helper::formatAmountWithNoE($balance->balance_free, 2) > Helper::formatAmountWithNoE($balance->balance, 2)) {
                    $error = true;
                }
            }
            if ($error) {
                return redirect('panel')->withErrors(['balanceError' => Lang::get('balance does not match Contact management')]);
            }
            return $next($request);
        }
        return $next($request);
    }
}
