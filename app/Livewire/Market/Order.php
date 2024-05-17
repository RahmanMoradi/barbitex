<?php

namespace App\Livewire\Market;

use anlutro\LaravelSettings\Facade as Settings;
use App\Helpers\Helper;
use App\Livewire\ValidateNotify;
use App\Models\Balance\Balance;
use App\Models\Currency\Currency;
use App\Models\Traid\Market\MarketOrder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use function Symfony\Component\String\s;

class Order extends Component
{
    use ValidateNotify;

    public $market, $min_buy, $countBuy, $balances, $amountBuy, $countSell, $amountSell, $count, $price, $time,
        $typeText, $type, $sum, $sumSell, $sumBuy, $orderType = 'limit';

    public function getListeners()
    {
        $userId = \Auth::id();
        $prefix = Helper::getBroadcasterPrefix();
        return [
            "echo:" . $prefix . "private-balance-Update-{$userId},.BalanceUpdate" => 'refreshBalance',
            "setAmountFromBook" => "setAmountFromBook",
            "refreshComponent" => '$refresh'
        ];
    }

    protected $rules = [
        'count' => 'required|numeric',
        'price' => 'required|numeric',
        'typeText' => 'required',
        'type' => 'required',
        'time' => 'required',
//        'sum' => "numeric|between:10,100000"
    ];
    /**
     * @var bool|mixed
     */
    private $error = false;

    public function refreshBalance()
    {
        $this->emit('$refresh');
        $this->emitTo(ActiveOrder::class, 'refreshComponent');
        $this->emitTo(MyOrders::class, 'refreshComponent');
    }

    public function mount(\App\Models\Traid\Market\Market $market)
    {
        $this->market = $market;
        $this->amountBuy = '';
        $this->amountSell = '';
        $this->countBuy = '';
        $this->countSell = '';
        $this->sumSell = '';
        $this->sumBuy = '';
    }


    public function render()
    {
        $this->min_buy = Settings::get('min_market_buy');
        $user = User::with('balances')->find(Auth::id());
        $balances = collect([
            'buy' => $user ? $user->balances->where('currency', $this->market->currencyBuyer->symbol)->first() : 0,
            'sell' => $user ? $user->balances->where('currency', $this->market->currencySeller->symbol)->first() : 0
        ]);
        $this->balances = $balances;
        return view('livewire.market.order', compact('balances', 'user'));
    }

    public function setAmount($type, $percent)
    {
        if ($type === 'sell') {
            $balance = $this->balances['buy'] ? $this->balances['buy']['balance_free'] : 0;
//            if ($balance < Settings::get('min_market_buy')) {
//                $this->countSell = 0;
//            } else {
            $amount = $balance * ($percent / 100);
            $this->countSell = Helper::numberFormatPrecision($amount, $this->market->currencyBuyer->decimal);
//            }

        } else {
            if ($this->amountBuy == '') {
                flash(Lang::get('enter the unit price'))->error()->liveWire($this);
                return;
            }
            $balance = $this->balances['sell'] ? $this->balances['sell']['balance_free'] : 0;
            if ($balance < Settings::get('min_market_buy')) {
                $min = Settings::get('min_market_buy');
                $this->countBuy = 0;
                flash(Lang::get('minimum amount of trading', ['amount' => $min, 'currency' => 'USDT']))->error()->livewire($this);
            } else {
                $fee = Settings::get('market_fee');
                $amount = $balance * ($percent / 100);
                $cal = ($amount - ($amount * $fee / 100));
                switch ($this->orderType) {
                    case 'limit':
                        $this->countBuy = Helper::numberFormatPrecision($cal / $this->amountBuy, $this->market->currencyBuyer->decimal);
                        break;
                    case 'market':
                        $this->countBuy = Helper::numberFormatPrecision($cal, $this->market->currencyBuyer->decimal);
                        break;
                }
            }

        }
        $this->changeSum($type);
    }

    public function addOrder($type)
    {
        if (!Auth::check() && !Auth::user()->isActive()) {
            flash(Lang::get('you have not yet verified'))->error()->livewire($this);
            return false;
        }
        switch ($this->orderType) {
            case 'limit':
                return $this->addOrderLimit($type);
                break;
            case 'market':
                return $this->addOrderMarket($type);
                break;
        }
    }

    private function orderStore()
    {
        try {
            \DB::transaction(function () {
                $currencyOne = $this->type == 'buy' ? Currency::find($this->market->currency_sell) : Currency::find($this->market->currency_buy);
                $currencyTwo = $this->type == 'sell' ? Currency::find($this->market->currency_buy) : Currency::find($this->market->currency_sell);

                $this->count = Helper::numberFormatPrecision($this->count, $this->type == 'buy' ? $currencyTwo->decimal_size : $currencyOne->decimal_size);
                $userId = Auth::id();
                $balanceOne = Balance::where('user_id', $userId)->where('currency', $currencyOne->symbol)->first();
                $balanceTwo = Balance::where('user_id', $userId)->where('currency', $currencyTwo->symbol)->first();

                if (!$balanceOne) {
                    Balance::createUnique($currencyOne->symbol, User::find($userId), 0);
                    $balanceOne = Balance::where('user_id', $userId)->where('currency', $currencyOne->symbol)->first();
                }
                if (!$balanceTwo) {
                    Balance::createUnique($currencyTwo->symbol, User::find($userId), 0);
                    $balanceTwo = Balance::where('user_id', $userId)->where('currency', $currencyTwo->symbol)->first();
                }
                if ($this->type == 'buy') {
                    switch ($this->orderType) {
                        case 'limit':
                            if ($balanceOne->balance_free < ($this->count * $this->price)) {
                                flash(Lang::get('balance insufficient'))->error()->livewire($this);
                                $this->error = true;
                                return;
                            }
                            break;
                        case 'market':
                            if ($balanceOne->balance_free < $this->count) {
                                flash(Lang::get('balance insufficient'))->error()->livewire($this);
                                $this->error = true;
                                return;
                            }
                            break;
                    }

                } else {
                    if ($balanceOne->balance_free < $this->count) {
                        flash(Lang::get('balance insufficient'))->error()->livewire($this);
                        $this->error = true;
                        return;
                    }
                }
                if ($this->type == 'buy') {
                    switch ($this->orderType) {
                        case 'limit':
                            $count = ($this->count * $this->price);
                            break;
                        case 'market':
                            $count = $this->sum;
                            break;
                    }
                    $balanceOne->update([
                        'balance_use' => $balanceOne->balance_use + $count,
                        'balance_free' => $this->orderType == 'limit' ?
                            ($balanceOne->balance_free - ($this->count * $this->price)) :
                            ($balanceOne->balance_free - $this->count)
                    ]);
                } else {
                    $balanceTwo->update([
                        'balance_use' => $balanceTwo->balance_use + $this->count,
                        'balance_free' => $balanceTwo->balance_free - $this->count
                    ]);
                }
                $marketOrder = $this->marketOrder();
                if ($marketOrder) {
                    if ($this->orderType == 'market' && $this->type == 'sell') {
                        $this->count = $marketOrder['size'];
                    }
                    $order = MarketOrder::create([
                        'market_id' => $this->market->id,
                        'market_order_id' => $marketOrder['orderId'],
                        'user_id' => $userId,
                        'count' => $this->orderType == 'limit' || $this->type == 'sell' ? $this->count :
                            Helper::numberFormatPrecision(($this->count / $marketOrder['price']), optional($this->market->currencyBuyer)->decimal_size),
                        'remaining' => $this->orderType == 'limit' || $this->type == 'sell' ? $this->count :
                            Helper::numberFormatPrecision(($this->count / $marketOrder['price']), optional($this->market->currencyBuyer)->decimal_size),
                        'price' => $this->price ? $this->price : $marketOrder['price'],
                        'sumPrice' => $this->orderType == 'limit' ? ($this->count * $this->price) : ($this->type == 'sell' ? ($this->count * $marketOrder['price']) : $this->count),
                        'type' => $this->type,
                        'status' => 'init'
                    ]);
                    $this->emitTo(ActiveOrder::class, 'refreshComponent');
                } else {
                    if ($this->type == 'buy') {
                        $balanceOne->update([
                            'balance_use' => $balanceOne->balance_use - ($this->count * $this->price),
                            'balance_free' => $balanceOne->balance_free + ($this->count * $this->price)
                        ]);
                    } else {
                        $balanceTwo->update([
                            'balance_use' => $balanceTwo->balance_use - $this->count,
                            'balance_free' => $balanceTwo->balance_free + $this->count
                        ]);
                    }
                    flash(Lang::get('the operation failed'))->error()->livewire($this);
                }
            });
        } catch (\Exception $exception) {
//            flash($exception->getMessage());
            \DB::rollBack();
        }
    }

    private function marketOrder()
    {
        switch ($this->orderType) {
            case 'limit':
                return $this->market->service()->createOrder($this->market->symbol, $this->count, $this->price, $this->type);
            case 'market':
                return $this->market->service()->createOrderMarket($this->market->symbol, $this->sum, $this->type);
        }
    }

    public function setAmountFromBook($amount, $count, $type)
    {
        if ($type == 'buy') {
            $this->countBuy = $count;
            $this->amountBuy = $amount;
            $this->orderType = 'limit';
        } elseif ($type == 'sell') {
            $this->countSell = $count;
            $this->amountSell = $amount;
            $this->orderType = 'limit';
        }
        $this->changeSum($type);
    }

    public function changeSum($type)
    {
        $fee = Settings::get('market_fee');
        if ($type == 'buy') {
            switch ($this->orderType) {
                case 'limit' :
                    $sum = ((float)$this->countBuy * (float)$this->amountBuy);
                    break;
                case 'market':
                    $sum = (float)$this->countBuy;
                    break;
            }
            $cal = $sum + ($sum * $fee / 100);
            $this->sumBuy = Helper::numberFormatPrecision(
                $cal, optional($this->market->currencyBuyer)->decimal
            );
        } else {
            switch ($this->orderType) {
                case 'limit' :
                    $sum = ((float)$this->countSell * (float)$this->amountSell);
                    break;
                case 'market':
                    $sum = (float)$this->countSell;
                    break;
            }
            $cal = ($sum - ($sum * $fee / 100));
            $this->sumSell = Helper::numberFormatPrecision($cal, optional($this->market->currencyBuyer)->decimal);
        }
    }

    public function updatedOrderType()
    {
        if ($this->orderType == 'market') {
            $this->amountBuy = Lang::get('the best market price');
            $this->amountSell = Lang::get('the best market price');
            $this->price = null;
        } else {
            $this->amountBuy = '';
            $this->amountSell = '';
        }
    }

    private function addOrderLimit($type)
    {
        $this->type = $type;
        $this->count = $type === 'sell' ? $this->countSell : $this->countBuy;
        $this->count = Helper::numberFormatPrecision($this->count, $this->market->decimal);
        $this->price = $type === 'sell' ? $this->amountSell : $this->amountBuy;
        $this->typeText = $type === 'sell' ? Lang::get('sell') : Lang::get('buy');
        $this->type = $type;
        $this->time = Carbon::now()->timestamp;
        $this->sum = (float)$this->count * (float)$this->price;
        if ($this->type == 'buy' || $this->orderType == 'limit') {
            $this->min_buy = Settings::get('min_market_buy');
        } else {
            $this->min_buy = Settings::get('min_market_buy') / optional($this->market->currencyBuyer)->price;
        }
        if ($this->sum < $this->min_buy) {
            flash(Lang::get('minimum amount of trading', ['amount' => $this->min_buy, 'currency' => 'USDT']))->error()->livewire($this);
            return;
        }
        $data = [
            'count' => $this->count,
            'price' => $this->price,
            'typeText' => $this->typeText,
            'type' => $this->typeText,
            'time' => $this->time,
            'sum' => $this->sum
        ];
        $this->validateNotify($data, $this->rules);
        $this->validate();
        $this->orderStore();
        if ($this->error == false) {
            $this->mount($this->market);
            flash(Lang::get('your order has been successfully registered'))->success()->liveWire($this);
        }
    }

    private function addOrderMarket($type)
    {
        $this->type = $type;
        $this->count = $type === 'sell' ? $this->countSell : $this->countBuy;
        $this->count = Helper::numberFormatPrecision($this->count, $this->market->decimal);
        $this->typeText = $type === 'sell' ? Lang::get('sell') : Lang::get('buy');
        $this->type = $type;
        $this->time = Carbon::now()->timestamp;
        $this->sum = $this->count;
        if ($this->type == 'buy' && $this->sum < $this->min_buy) {
            flash(Lang::get('minimum amount of trading', ['amount' => $this->min_buy, 'currency' => 'USDT']))->error()->livewire($this);
            return;
        }
        $data = [
            'count' => 0,
            'price' => 0,
            'typeText' => $this->typeText,
            'type' => $this->type,
            'time' => $this->time,
            'sum' => $this->sum
        ];
        $this->validateNotify($data, $this->rules);
//        $this->validate();
        $this->orderStore();
        if ($this->error == false) {
            $this->mount($this->market);
            flash(Lang::get('your order has been successfully registered'))->success()->liveWire($this);
        }
    }

    public function updatedAmountBuy()
    {
        $this->changeSum('buy');
    }

    public function updatedCountBuy()
    {
        $this->changeSum('buy');
    }

    public function updatedAmountSell()
    {
        $this->changeSum('sell');
    }

    public function updatedCountSell()
    {
        $this->changeSum('sell');
    }
}
