<?php

namespace App\Livewire\Admin;

use App\Models\Currency\Currency;
use App\Models\Order\Order;
use App\Models\Traid\Market\Market;
use App\Models\Traid\Market\MarketOrder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $searchProfessional, $searchPlain, $filterStatus, $filterType, $filterUser, $filterMarket,
        $filterPlainStatus, $filterPlainType, $filterPlainUser, $filterPlainCurrency;

    public function render()
    {
        $users = User::all();
        $markets = Market::whereStatus(true)->get();
        $currencies = Currency::all();
        if ($this->searchProfessional || $this->filterStatus || $this->filterType || $this->filterUser || $this->filterMarket) {
            $ordersProfessional = $this->filter('professional');
        } else {
            $ordersProfessional = MarketOrder::with('market')
                ->orderByDesc('updated_at')
                ->paginate(10);
        }
        if ($this->searchPlain || $this->filterPlainStatus || $this->filterPlainType || $this->filterPlainUser || $this->filterPlainCurrency) {
            $ordersPlain = $this->filter('plain');
        } else {
            $ordersPlain = Order::orderByDesc('updated_at')
                ->paginate(10);
        }

        return view('livewire.admin.orders', compact('ordersProfessional', 'ordersPlain', 'users', 'markets', 'currencies'));
    }

    private function filter($type)
    {
        $orderProfessional = MarketOrder::query();
        if ($type == 'professional') {
            if ($this->searchProfessional) {
                $orderProfessional->whereHas('market', function ($query) {
                    return $query->where('symbol', 'LIKE', '%' . $this->searchProfessional . '%');
                })
                    ->orwhereHas('user', function ($query) {
                        return $query->where('name', 'LIKE', '%' . $this->searchProfessional . '%');
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
            if ($this->filterUser) {
                $orderProfessional->with('market')
                    ->whereUserId($this->filterUser);
            }
            if ($this->filterMarket) {
                $orderProfessional->with('market')
                    ->whereMarketId($this->filterMarket);
            }

            return $orderProfessional->orderByDesc('updated_at')->paginate(10);
        } else {
            $order = Order::query();
            if ($this->searchPlain) {
                $order->whereHas('user', function ($query) {
                    return $query->where('name', 'LIKE', '%' . $this->searchPlain . '%');

                })
                    ->orwhereHas('currency', function ($query) {
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
            if ($this->filterPlainUser) {
                $order->whereUserId($this->filterPlainUser);
            }
            if ($this->filterPlainCurrency) {
                $order->whereCurrencyId($this->filterPlainCurrency);
            }

            return $order->orderByDesc('updated_at')
                ->paginate(10);
        }
    }

    public function markAsDone(MarketOrder $order)
    {
        if ($order->market->service()->checkActive($order)) {
            flash(Lang::get('order is open', ['orderId' => $order->id]))->error()->livewire($this);

            return;
        }
        $order->update([
            'status' => 'done',
            'remaining' => 0
        ]);

        $message = Lang::get('order done', ['orderId' => $order->id]);
        flash($message)->success()->livewire($this);
    }

    public function checkAllOpenOrder()
    {
        $marketOrders = MarketOrder::where('status', 'init')->get();
        foreach ($marketOrders as $marketOrder) {
            $this->markAsDone($marketOrder);
        }
    }
}
