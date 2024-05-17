<?php

namespace App\Http\Controllers\Panel;

use anlutro\LaravelSettings\Facade as Settings;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Livewire\Market\Market;
use App\Models\Balance\Balance;
use App\Models\Currency\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanelController extends Controller
{
    public function index()
    {
        $currencies = Currency::where('active', 1)->where('type', 'coin')->paginate();
        $balanceDb = Balance::where('user_id', Auth::id())
            ->where('balance_free', '>', 0)->get();
        $balance = [];
        foreach ($balanceDb as $item) {
            if ($item->currency == 'IRT') {
                $data = [
                    'currency' => $item->currency,
                    'balance' => $item->balance_free,
                    'balanceIrt' => Helper::numberFormatPrecision($item->balance, 0)
                ];
            } else {
                $data = [
                    'currency' => $item->currency,
                    'balance' => $item->balance_free,
                    'balanceIrt' => Helper::numberFormatPrecision($item->balance * (optional($item->currencyModel)->price * Settings::get('dollar_sell_pay')), 0)
                ];
            }
            array_push($balance, $data);
        }
        if (count($balance) == 0) {
            $balance = [
                [
                    'currency' => 'IRT',
                    'balance' => 0,
                    'balanceIrt' => 0
                ]
            ];

        }
        return view('panel.panel.index', compact('currencies', 'balance'));
    }

    public function changeTheme($theme)
    {
        Auth::user()->update([
            'theme' => $theme
        ]);

        return back();
    }
}
