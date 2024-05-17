<?php

namespace App\Livewire\Panel\Order;

use anlutro\LaravelSettings\Facade as Settings;
use App\Helpers\Helper;
use App\Livewire\Market\TradingView;
use App\Livewire\ValidateNotify;
use App\Models\Balance\Balance;
use App\Models\Currency\Currency;
use App\Models\Order\Order;
use App\Models\Traid\Market\Market;
use App\Models\Wallet;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class Create extends Component
{
    use ValidateNotify, WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $queryString = ['type', 'qty'];

    public $currency, $type = 'buy', $price, $qty, $balance, $search, $minPrice, $market;

//    public function getListeners()
//    {
//        $prefix = Helper::getBroadcasterPrefix();
//        return [
//            "echo:" . $prefix . "price-update-{$this->currency->symbol},.priceUpdate" => 'UpdatePrice',
//        ];
//    }

//    public function UpdatePrice()
//    {
//            $this->changeQty();

//    }

    public function mount()
    {
        if (request()->has('currency')) {
            $this->currency = Currency::whereSymbol(request()->get('currency'))->where('active', true)
                ->first();
            if (!$this->currency) {
                flash(Lang::get('currency not found!'))->error()->livewire($this);
                $this->currency = $this->getCurrencies()[0];
            }
        } else {
            $this->currency = $this->getCurrencies()[0];
        }
        $this->market = Market::where('currency_buy', $this->currency->id)->first();
        $this->calculateBalance();
        $this->minPrice = $this->type == 'buy' ? Settings::get('min_buy') : Settings::get('min_sell');
        $this->updatedQty();
    }

    public function render()
    {
        $currencies = $this->getCurrencies();
        return view('livewire.panel.order.create', compact('currencies'));
    }

    public function updatedSearch()
    {
        $this->getCurrencies();
    }

    private function getCurrencies()
    {
        if ($this->search) {
            return Currency::where('active', true)
                ->where('type', 'coin')
                ->where('name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('symbol', 'LIKE', '%' . $this->search . '%')
                ->orderBy('position')->paginate();
        } else {
            return Currency::where('active', true)->orderBy('position')->where('type', 'coin')->paginate();
        }
    }

    public function updatedQty()
    {
        $this->changeQty();
    }

    public function updatedPrice()
    {
        $this->price = number_format($this->removeFormat());
        $this->changeSumPrice();
    }

    public function changeQty()
    {
        $this->price = number_format((float)$this->qty * ($this->type == 'buy' ?
                (float)optional($this->currency)->send_price : (float)optional($this->currency)->receive_price));
    }

    public function changeSumPrice()
    {
        $minPrice = $this->type == 'buy' ? Settings::get('min_buy') : Settings::get('min_sell');
        $calculate = $this->removeFormat() < $minPrice ? 0 : $this->removeFormat() / ($this->type == 'buy' ?
                (float)$this->currency->send_price : (float)$this->currency->receive_price);
        $this->qty = $calculate > 0 ? Helper::numberFormatPrecision($calculate, $this->currency->decimal_size) : 0;
    }

    public function max()
    {
        if ($this->type == 'buy') {
            $this->price = number_format($this->balance);
            $this->changeSumPrice();
        } else {
            $this->qty = $this->balance;
            $this->changeQty();
        }
    }

    public function changeCurrency($key)
    {
        $this->currency = $this->getCurrencies()[$key];
        $this->changeQty();
        $this->calculateBalance();
        $this->search = null;
        $symbol = $this->currency['symbol'];
        return $this->redirect("/panel/order/create?currency=$symbol");
    }

    public function changeType($type)
    {
        $this->type = $type;
        $this->changeQty();
        $this->calculateBalance();
    }

    public function submit()
    {
        try {
            DB::transaction(function () {
                $this->qty = Helper::numberFormatPrecision($this->qty, $this->currency->decimal_size);
                $this->validateMyForm();
                $this->decrementBalance();
                $order = $this->createOrder();
                $this->incrementBalance($order);
                if ($this->currency->symbol != 'USDT') {
                    $this->currency->service()->tradToCurrency($order);
                }
                $this->calculateBalance();
                $this->qty = 0;
                flash(Lang::get('operation completed successfully'))->success()->livewire($this);
            });
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            DB::rollBack();
        }
    }

    private function validateMyForm()
    {
        if ($this->currency->symbol != 'USDT') {
            $this->currency->service()->getLastPrice($this->currency);
            $this->currency = Currency::where('symbol', $this->currency->symbol)->first();
        }
        $this->calculateBalance();
        $this->price = (float)$this->qty * ($this->type == 'buy' ? (float)$this->currency->send_price : (float)$this->currency->receive_price);
        $data = [
            'type' => $this->type,
            'qty' => $this->qty,
            'price' => $this->price,
            'balance' => $this->balance
        ];
        $minBalance = $this->type == 'buy' ? $this->price : $this->qty;
        $minPrice = $this->type == 'buy' ? Settings::get('min_buy') : Settings::get('min_sell');
        $maxPrice = $this->type == 'buy' ? \Auth::user()->max_buy : 99999999999;
        $rules = [
            'type' => 'required|in:buy,sell',
            'qty' => 'required',
            'price' => "required|numeric|between:$minPrice,$maxPrice",
            'balance' => "required|numeric|min:$minBalance",
        ];
        $this->validateNotify($data, $rules);
        $this->validate($rules);
    }

    private function createOrder()
    {
        try {
            $data = [
                'currency_id' => $this->currency->id,
                'user_id' => \Auth::id(),
                'type' => $this->type,
                'qty' => $this->qty,
                'price' => $this->price,
                'usdt_price' => $this->type == 'buy' ? Settings::get('dollar_buy_pay') : Settings::get('dollar_sell_pay'),
            ];
            return Order::create($data);
        } catch (Exception $exception) {
            flash(Lang::get('the operation failed'))->error()->livewire($this);
        }
    }

    private function decrementBalance()
    {
        $typeTxt = $this->type == 'buy' ? Lang::get('buy') : Lang::get('sell');
        Wallet::create(
            [
                'user_id' => \Auth::id(),
                'currency' => $this->type == 'sell' ? $this->currency->symbol : 'IRT',
                'price' => $this->type == 'sell' ? $this->qty : $this->price,
                'wallet' => 'global_wallet',
                'description' => Lang::get('withdrawal for order', ['type' => $typeTxt]),
                'type' => 'decrement',
                'status' => 'done'
            ]
        );
        Balance::createUnique($this->type == 'buy' ? 'IRT' :
            $this->currency->symbol, \Auth::user(),
            $this->type == 'buy' ? -$this->price : -$this->qty);
    }

    private function incrementBalance($order)
    {
        Wallet::create(
            [
                'user_id' => \Auth::id(),
                'currency' => $this->type == 'buy' ? $this->currency->symbol : 'IRT',
                'price' => $this->type == 'buy' ? $this->qty : $this->price,
                'wallet' => 'global_wallet',
                'description' => Lang::get('deposit for order number', ['orderId' => $order->id]),
                'type' => 'increment',
                'status' => Settings::get('autoDeposit') == '1' ? 'done' : 'new',
            ]
        );
        if (Settings::get('autoDeposit') == '1') {
            Balance::createUnique($this->type == 'buy' ? $this->currency->symbol : 'IRT',
                Auth::user(), $this->type == 'buy' ? $this->qty : $this->price);
        }
        $order->update([
            'status' => 'done'
        ]);
    }

    private function calculateBalance()
    {
        $balanceCurrency = Balance::where('user_id', \Auth::id())->where('currency', $this->type == 'buy' ? 'IRT' : $this->currency->symbol)->first();
        if (!$balanceCurrency) {
            Balance::createUnique($this->type == 'buy' ? 'IRT' : $this->currency->symbol, \Auth::user(), 0);
            $balanceCurrency = Balance::where('user_id', \Auth::id())->where('currency', $this->type == 'buy' ? 'IRT' : $this->currency->symbol)->first();
        }
        $this->balance = $balanceCurrency->balance_free;
    }

    private function removeFormat()
    {
        return intval(preg_replace('/[^\d. ]/', '', $this->price));
    }
}
