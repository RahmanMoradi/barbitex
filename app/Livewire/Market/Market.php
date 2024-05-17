<?php

namespace App\Livewire\Market;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Market extends Component
{
    public $market, $title;

//    public function getListeners()
//    {
//        $market = $this->market;
//        if (!$market) {
//            return abort(404);
//        }
//        $prefix = Helper::getBroadcasterPrefix();
//        return [
//            "refreshComponent-{$market->symbol}" => "OrderPalcedEvent"
//        ];
//    }
//
//    public function OrderPalcedEvent()
//    {
//        $this->emitTo(Chart::class, 'refreshComponent');
//        $this->emitTo(Markets::class, 'refreshComponent');
//        $this->emitTo(LastOrder::class, 'refreshComponent');
//        $this->emitTo(\App\Livewire\Panel\Markets::class, 'refreshComponent');
//        $this->emitTo(\App\Livewire\Admin\Markets::class, 'refreshComponent');
//        $this->emitTo(ActiveOrder::class, 'refreshComponent');
//        $this->emitTo(MyOrders::class, 'refreshComponent');
//    }

    public function UpdatePriceMarketEvent()
    {
        $this->emitTo(ActiveOrder::class, 'refreshComponent');
    }

    public function BalanceUpdateEvent()
    {
        $this->emitTo(Order::class, 'refreshComponent');
    }

    public function mount($market)
    {
        $this->market = $market;
    }

    public function render()
    {
        return view('livewire.market.market');
    }

    public function updateTitle()
    {
        $markets = Cache::get("marketsList", []);
        $key = array_search($this->symbol, array_column($markets, 'symbol'));

        $this->title = $markets[$key]['price'] ? $markets[$key]['price'] : '';
    }
}
