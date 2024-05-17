<?php

namespace App\Livewire\Market;

use App\Livewire\refreshComponent;
use App\Models\Traid\Market\MarketOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Livewire\Component;

class MyOrders extends Component
{
    public $market;
    use refreshComponent;

    public function mount(\App\Models\Traid\Market\Market $market)
    {
        $this->market = $market;
    }

    public function render()
    {
        $myOrders = MarketOrder::where('user_id', Auth::id())->where('market_id', $this->market->id)
            ->where('status', 'done')->limit(15)->orderByDesc('created_at')->get();

        return view('livewire.market.my-orders', compact('myOrders'));
    }
}
