<?php

namespace App\Livewire\Panel;

use App\Livewire\Market\ActiveOrder;
use App\Models\Currency\Currency;
use App\Models\Order\Order;
use App\Models\Traid\Market\Market;
use App\Models\Traid\Market\MarketOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $searchProfessional, $searchPlain, $filterStatus, $filterType, $filterMarket,
        $filterPlainStatus, $filterPlainType, $filterPlainCurrency;

    public function render()
    {
        $markets = Market::whereStatus(true)->get();
        $currencies = Currency::all();
        if ($this->searchProfessional || $this->filterStatus || $this->filterType || $this->filterMarket) {
            $myOrders = $this->filter('professional');
        } else {
            $myOrders = MarketOrder::with('market')
                ->where('user_id', Auth::id())
                ->orderByDesc('updated_at')
                ->paginate(10);
        }
        if ($this->searchPlain || $this->filterPlainStatus || $this->filterPlainType || $this->filterPlainCurrency) {
            $planeOrders = $this->filter('plain');
        } else {
            $planeOrders = Order::where('user_id', Auth::id())->orderByDesc('updated_at')->paginate(10, ['*'], 'pa');
        }

        $myOpenOrders = MarketOrder::with('market')
            ->where('user_id', Auth::id())
            ->where('status', 'init')
            ->orderByDesc('updated_at')
            ->paginate(10, ['*'], 'opa');
        return view('livewire.panel.orders', compact('myOrders', 'planeOrders', 'myOpenOrders', 'markets', 'currencies'));
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
                $this->emitTo(\App\Livewire\Market\Order::class, 'refreshComponent');
                $this->emitTo(ActiveOrder::class, 'refreshComponent');
            } else {
                flash(Lang::get('the operation failed'))->error()->livewire($this);
            }
        } else {
            flash(Lang::get('it is not possible to delete this order'))->error()->livewire($this);
        }
    }

    private function filter($type)
    {
        if ($type == 'professional') {
            $orderProfessional = MarketOrder::query();
            if ($this->searchProfessional) {
                $orderProfessional
                    ->whereHas('market', function ($query) {
                        return $query->where('symbol', 'LIKE', '%' . $this->searchProfessional . '%');
                    })
                    ->orWhere('id', 'LIKE', '%' . $this->searchProfessional . '%')
                    ->orWhere('count', 'LIKE', '%' . $this->searchProfessional . '%')
                    ->orWhere('price', 'LIKE', '%' . $this->searchProfessional . '%');

            }
            if ($this->filterStatus) {
                $orderProfessional->with('market')
                    ->whereStatus($this->filterStatus);
            }
            if ($this->filterType) {
                $orderProfessional->with('market')
                    ->whereType($this->filterType);
            }
            if ($this->filterMarket) {
                $orderProfessional->with('market')
                    ->whereMarketId($this->filterMarket);
            }
            return $orderProfessional->where('user_id', Auth::id())->orderByDesc('updated_at')
                ->paginate(10);
        } else {
            $order = Order::query();
            if ($this->searchPlain) {
                $order
                    ->whereHas('currency', function ($query) {
                        return $query->where('symbol', 'LIKE', '%' . $this->searchPlain . '%');
                    })
                    ->orWhere('id', 'LIKE', '%' . $this->searchPlain . '%')
                    ->orWhere('qty', 'LIKE', '%' . $this->searchPlain . '%')
                    ->orWhere('price', 'LIKE', '%' . $this->searchPlain . '%');

            }
            if ($this->filterPlainStatus) {
                $order->whereStatus($this->filterPlainStatus);
            }
            if ($this->filterPlainType) {
                $order->whereType($this->filterPlainType);
            }

            if ($this->filterPlainCurrency) {
                $order->whereCurrencyId($this->filterPlainCurrency);
            }

            return $order->where('user_id', Auth::id())->orderByDesc('updated_at')
                ->paginate(10, ['*'], 'pa');
        }
    }

}
