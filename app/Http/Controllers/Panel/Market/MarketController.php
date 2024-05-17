<?php

namespace App\Http\Controllers\Panel\Market;

use anlutro\LaravelSettings\Facade as Setting;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Traid\Market\Market;
use App\Models\Traid\Market\MarketHistory;
use App\Models\Traid\Market\MarketOrder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MarketController extends Controller
{
    public function __construct()
    {
        $needLogin = Cache::remember('guestShowMarket', 50000, function () {
            return Setting::get('guestShowMarket') == 0;
        });
        if ($needLogin) {
            $this->middleware(['auth', 'userActive', 'cardActive']);
        }
    }

    public function show($symbol)
    {
        if ($symbol == 'null') {
            return redirect("market/$symbol");
        }
        $marketVersion = Cache::remember('marketVersion', 50000, function () {
            return Setting::get('marketVersion');
        });
        if ($marketVersion == 2) {
            $market = Market::whereStatus('1')->where('symbol', $symbol)->with('currencyBuyer', 'currencySeller')->firstOrFail();
            $markets = Market::where('status', 1)->orderBy('created_at')->get();
            return view('market.v2', compact('market', 'markets'));
        }else{
            $symbol = Market::whereStatus('1')->where('symbol', $symbol)->with('currencyBuyer', 'currencySeller')->firstOrFail();
            return view('market.show', compact('symbol'));
        }

    }

    public function redirect()
    {
        $symbol = Market::whereStatus(1)->with('currencyBuyer', 'currencySeller')->orderBy('created_at')->firstOrFail()->symbol;

        return redirect(route('market.market', ['market_symbol' => $symbol]));
    }

    public function transactions()
    {
        return view('panel.market.transactions');
    }

    public function showV2($symbol)
    {
        if ($symbol == 'null') {
            return redirect("market/$symbol");
        }
        $market = Market::whereStatus('1')->where('symbol', $symbol)->with('currencyBuyer', 'currencySeller')->first();
        $markets = Market::where('status', 1)->orderBy('created_at')->get();
        return view('market.v2', compact('market', 'markets'));
    }
}
