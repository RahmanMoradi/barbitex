<?php

namespace App\Livewire\Market;

use App\Livewire\refreshComponent;
use App\Models\Balance\Balance;
use App\Models\Currency\Currency;
use App\Models\Traid\Market\MarketOrder;
use App\Models\User;
use App\Models\Webazin\Binance\Facades\Binance;
use App\Models\Webazin\Kucoin\Facades\Kucoin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class ActiveOrder extends Component
{
    use refreshComponent;

    public $market;


    public function mount($market)
    {
        $this->market = $market;
    }

    public function render()
    {
        $activeOrders = marketOrder::where('user_id', Auth::id())->where('market_id', $this->market->id)->where('status', 'init')->orderByDesc('created_at')->get();

        return view('livewire.market.active-order', compact('activeOrders'));
    }

    public function delete(MarketOrder $order)
    {
        if ($order->user_id != Auth::id()) {
            flash(Lang::get('illegal access'))->error()->livewire($this);
            return false;
        }

        if ($order->status == 'init' && $order->remaining > 0) {
//            TODO REMAINING
            if ($order->market->service()->cancelOrder($order)) {

                flash(Lang::get('operation completed successfully'))->success()->livewire($this);
                $this->emitTo(Order::class, 'refreshComponent');
            } else {
                flash(Lang::get('the operation failed'))->error()->livewire($this);
            }
        } else {
            flash(Lang::get('it is not possible to delete this order'))->error()->livewire($this);
        }
    }
}
