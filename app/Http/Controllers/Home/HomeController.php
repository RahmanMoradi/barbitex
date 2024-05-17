<?php

namespace App\Http\Controllers\Home;

use anlutro\LaravelSettings\Facade as Setting;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Article\Article;
use App\Models\Currency\Currency;
use App\Models\Traid\Market\Market;

class HomeController extends Controller
{
    public function index()
    {
        if (Setting::get('homeTheme') == 'wordpress') {
            return redirect('panel');
        }
        if (Setting::get('homeTheme') == 'v2') {
            $posts = Article::where('vip', 0)
                ->where('discount', 0)
                ->where('accreditation', 0)
                ->where('metaverse', 0)
                ->where('analysis', 0)
                ->where('airdrop', 0)
                ->where('show_app', 0)
                ->where('reward', 0)->paginate(6);
            $marketsHome = Market::paginate(4);
            $marketsTable = Currency::paginate();
            return view('home.v2.index', compact('marketsHome', 'marketsTable', 'posts'));
        } elseif (Setting::get('homeTheme') == 'v3') {
            $isMarket = Helper::modules()['market'];
            if ($isMarket) {
                $latestMarket = Market::where('status', 1)->orderByDesc('created_at')->paginate(5);
            } else {
                $latestMarket = Currency::where('active', 1)->whereNotIn('symbol', ['PM'])->orderByDesc('created_at')->paginate(6);
            }
            $lossMarket = Currency::where('active', 1)->whereNotIn('symbol', ['PM'])->orderByRaw('CONVERT(percent, SIGNED)')->paginate(5);
            $gainersMarket = Currency::where('active', 1)->whereNotIn('symbol', ['PM'])->orderByRaw('CONVERT(percent, SIGNED) desc')->paginate(5);

            return view('home.v3', compact('latestMarket', 'isMarket', 'gainersMarket', 'lossMarket'));
        } elseif (Setting::get('homeTheme') == 'v4') {
            $posts = Article::where('vip', 0)
                ->where('discount', 0)
                ->where('accreditation', 0)
                ->where('metaverse', 0)
                ->where('analysis', 0)
                ->where('airdrop', 0)
                ->where('show_app', 0)
                ->where('reward', 0)->paginate(6);
            $marketsHome = Market::paginate(4);
            $marketsTable = Currency::where('type','coin')->get()->take(15);

            return view('home.v4.index', compact('marketsHome', 'marketsTable', 'posts'));
        } else {
            $isMarket = Helper::modules()['market'];
            if ($isMarket) {
                $marketsHome = Market::with('currencyBuyer')->where('status', 1)->orderBy('created_at')->limit(6)->get();
                $marketsTable = Market::where('status', 1)->with('currencyBuyer')->orderBy('created_at')->get();
            } else {
                $marketsHome = Currency::where('active', 1)->paginate(6);
                $marketsTable = Currency::where('active', 1)->get();
            }
        }
        return view('home.index', compact('marketsTable', 'marketsHome', 'isMarket'));
    }
}
