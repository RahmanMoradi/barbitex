<?php

namespace App\Livewire\Panel\Portfolio;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class Portfolio extends Component
{
    public function render()
    {
        $portfolios = collect();
        $portfoliosGroup = \App\Models\Portfolio\Portfolio::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get()->groupBy('symbol');
        foreach ($portfoliosGroup as $portfolio) {
            $remaining = ($portfolio->where('order.type', 'buy')->sum('order.count') + $portfolio->where('order.type', 'buy')->sum('order.qty'))
                - ($portfolio->where('order.type', 'sell')->sum('order.count') + $portfolio->where('order.type', 'sell')->sum('order.qty'));
            if ($remaining > 0) {

                $currency = $portfolio[0]->order_id ? $portfolio[0]->order->currency : $portfolio[0]->order->market->currencyBuyer;
                $sumBuy = $portfolio[0]->order_id ? $portfolio->where('order.type', 'buy')->average('order.qty') : $portfolio->where('order.type', 'buy')->average('order.count');
                $averageBuy = $portfolio->where('order.type', 'buy')->average('order.price');
                $irtPrice = $portfolio[0]->order_id ? $averageBuy / $sumBuy : '-';
                $usdtPrice = $portfolio[0]->market_order_id ? $averageBuy : $irtPrice / $portfolio->where('order.type', 'buy')->average('order.usdt_price');
                $percent = Helper::numberFormatPrecision(100 - (($usdtPrice * 100) / $currency->price), 2);

                $item = [
                    'id' => $portfolio[0]->id,
                    'symbol' => $portfolio[0]->symbol,
                    'icon' => $currency->iconUrl,
                    'remaining' => $remaining,
                    'unit_irt' => number_format(floatval($irtPrice)) . ' ' . Lang::get('IRT'),
                    'unit_usdt' => Helper::numberFormatPrecision($usdtPrice) . ' $',
                    'unit_irt_now' => number_format($currency->irt_price) . ' ' . Lang::get('IRT'),
                    'unit_usdt_now' => Helper::numberFormatPrecision($currency->price) . ' $',
                    'percent' => $percent . '%',
                    'positive' => $percent > 0,
                    'sum_irt' => number_format($remaining * floatval($irtPrice)) . ' ' . Lang::get('IRT'),
                    'sum_irt_now' => number_format(($remaining * $currency->irt_price) + ((($remaining * $currency->irt_price) * $percent) / 100)) . ' ' . Lang::get('IRT'),
                    'sum_usdt' => Helper::numberFormatPrecision($remaining * $usdtPrice) . ' $',
                    'sum_usdt_now' => Helper::numberFormatPrecision(($remaining * $currency->price) + (($remaining * $currency->price) * $percent) / 100) . ' $',
                    'position' => Helper::numberFormatPrecision(($remaining * $currency->price) + (($remaining * $currency->price) * $percent) / 100),
                    'irt_oscillation' => number_format((($remaining * $currency->irt_price) * $percent) / 100) . ' ' . Lang::get('IRT'),
                    'usdt_oscillation' => Helper::numberFormatPrecision((($remaining * $currency->price) * $percent) / 100) . ' $',
                ];

                $portfolios->push($item);
            }
        }
        $portfolios = $portfolios->sortByDesc('position');
        return view('livewire.panel.portfolio.portfolio', compact('portfolios'));
    }
}
