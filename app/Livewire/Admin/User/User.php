<?php

namespace App\Livewire\Admin\User;

use anlutro\LaravelSettings\Facade as Settings;
use App\Helpers\Helper;
use App\Livewire\Admin\Wallet\Transactions;
use App\Livewire\Market\ActiveOrder;
use App\Livewire\ValidateNotify;
use App\Models\Balance\Balance;
use App\Models\Currency\Currency;
use App\Models\Traid\Market\Market;
use App\Models\Traid\Market\MarketOrder;
use App\Models\User\ValidCode;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use Livewire\WithPagination;

class User extends Component
{
    use ValidateNotify, WithPagination;

    protected $paginationTheme = 'bootstrap';

    /**
     * @var \App\Models\User|mixed
     */
    public $user, $name, $mobile, $email, $password, $password_confirmation,
        $type, $price, $currency, $description, $max_buy,
        $markets, $orderType, $orderPrice, $orderQty, $orderMarket, $orderMarketId, $error = false, $validCode;

    protected $rules = [
        'mobile' => 'required',
        'email' => 'required',
        'name' => 'required',
    ];
    /**
     * @var mixed
     */

    /**
     * @var mixed
     */

    public function mount(\App\Models\User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->mobile = $user->mobile;
        $this->email = $user->email;
        $this->max_buy = $user->max_buy;
        $this->password = null;
        $this->password_confirmation = null;
        $this->type = 'increment';
        $this->price = null;
        $this->currency = 'IRT';
        $this->description = null;
        $this->markets = Market::whereStatus(1)->get();
        $validCode = ValidCode::where('user_id', $user->id)->first();
        $this->validCode = $validCode ? $validCode->code : '';
    }

    public function render()
    {
        $subsets = \App\Models\User::where('parent_id', $this->user->id)->paginate();
        $currencies = Currency::all();
        $wallets = Wallet::where('user_id', $this->user->id)->orderByDesc('updated_at')->paginate();
        $balances = Balance::where('user_id', $this->user->id)->where('balance', '>', 0)->paginate();
        return view('livewire.admin.user.user', compact('currencies', 'wallets', 'balances', 'subsets'));
    }

    public function changeStatus($attribute, $status)
    {
        switch ($attribute) {
            case 'email':
                $this->user->update([
                    'email_verified_at' => $status ? Carbon::now() : null
                ]);
                break;
            case 'mobile':
                $this->user->update([
                    'mobile_verified_at' => $status ? Carbon::now() : null
                ]);
                break;
            case 'document':
                $this->user->update([
                    'doc_verified_at' => $status ? Carbon::now() : null
                ]);
                break;
        }

        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
        $this->mount($this->user);
    }

    public function update()
    {
        $data = [
            'mobile' => $this->mobile,
            'email' => $this->email,
            'name' => $this->name,
        ];

        $this->validateNotify($data, $this->rules);
        $this->validate();

        $this->user->update($data);
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
        $this->mount($this->user);
    }

    public function changePassword()
    {
        $rules = [
            'password' => 'required|confirmed',
        ];
        $data = [
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ];
        $this->validateNotify($data, $rules);
        $this->validate($rules);

        $this->user->update([
            'password' => Hash::make($this->password)
        ]);
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
        $this->mount($this->user);
    }

    public function documentChangeStatus($status)
    {
        if (!$this->user->docs) {
            flash(Lang::get('this operation is not possible') . ' ' . Lang::get('waiting for upload'))->error()->livewire($this);
            return;
        }

        if ($status == 'accept') {
            $this->user->markDocAsVerified();
        } elseif ($status == 'failed') {
            $this->user->markDocAsFailed();
        } else {
            $this->user->update([
                'doc_verified_at' => null,
            ]);
        }
        $this->user->docs->update(['status' => $status]);

        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
        $this->mount($this->user);
    }

    public function walletStore()
    {
        $rules = [
            'type' => 'required|in:increment,decrement',
            'price' => 'required|numeric',
            'currency' => 'required',
        ];
        $data = [
            'type' => $this->type,
            'price' => $this->price,
            'currency' => $this->currency,
        ];
        $this->validateNotify($data, $rules);
        $this->validate($rules);
        $wallet = Wallet::create([
            'user_id' => $this->user->id,
            'currency' => $this->currency,
            'price' => $this->type == 'increment' ? $this->price : -($this->price),
            'description' => $this->description ?: Lang::get('performed by management'),
            'type' => $this->type,
            'status' => 'done'
        ]);
        Balance::createUnique($this->currency, $this->user, $this->type == 'increment' ? $this->price : -($this->price));
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);

        $this->mount($this->user);
    }

    public function maxBuyUpdate()
    {
        $rules = [
            'max_buy' => 'required|numeric'
        ];
        $data = [
            'max_buy' => $this->max_buy
        ];
        $this->validateNotify($data, $rules);
        $this->validate($rules);
        $this->user->update($data);
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
        $this->mount($this->user);
    }

    public function addOrder()
    {
        if (!$this->user->isActive()) {
            flash(Lang::get('user not verified'))->error()->livewire($this);
            return false;
        }
        $this->orderMarket = Market::findOrFail($this->orderMarketId);
        $count = Helper::numberFormatPrecision($this->orderQty, $this->orderMarket->decimal);
        $typeText = $this->orderType === 'sell' ? Lang::get('sell') : Lang::get('buy');
        $time = Carbon::now()->timestamp;
        $sum = (float)$count * (float)$this->orderPrice;
        $minBuy = Settings::get('min_market_buy');
        if ($sum < $minBuy) {
            flash(Lang::get('minimum amount of trading', ['amount' => $minBuy, 'currency' => 'USDT']))->error()->livewire($this);
            return;
        }
        $data = [
            'count' => $count,
            'price' => $this->orderPrice,
            'typeText' => $typeText,
            'type' => $this->orderType,
            'time' => $time,
            'sum' => $sum
        ];
        $rules = [
            'count' => 'required|numeric',
            'price' => 'required|numeric',
            'typeText' => 'required',
            'type' => 'required',
            'time' => 'required',
//        'sum' => "numeric|between:10,100000"
        ];
        $this->validateNotify($data, $rules);
        $this->orderStore($count);
        if ($this->error == false) {
            flash(Lang::get('operation completed successfully'))->success()->liveWire($this);
            $this->orderPrice = '';
            $this->orderType = '';
            $this->orderQty = '';
        }
    }

    private function orderStore($count)
    {
        $userId = $this->user->id;

        $currencyOne = $this->orderType == 'buy' ? Currency::find($this->orderMarket->currency_sell) : Currency::find($this->orderMarket->currency_buy);
        $currencyTwo = $this->orderType == 'sell' ? Currency::find($this->orderMarket->currency_buy) : Currency::find($this->orderMarket->currency_sell);
        $balanceOne = Balance::where('user_id', $userId)->where('currency', $currencyOne->symbol)->first();
        $balanceTwo = Balance::where('user_id', $userId)->where('currency', $currencyTwo->symbol)->first();

        if (!$balanceOne) {
            Balance::createUnique($currencyOne->symbol, \App\Models\User::find($userId), 0);
            $balanceOne = Balance::where('user_id', $userId)->where('currency', $currencyOne->symbol)->first();
        }
        if (!$balanceTwo) {
            Balance::createUnique($currencyTwo->symbol, User::find($userId), 0);
            $balanceTwo = Balance::where('user_id', $userId)->where('currency', $currencyTwo->symbol)->first();
        }
        if ($this->orderType == 'buy') {
            if ($balanceOne->balance_free < ($count * $this->orderPrice)) {
                flash(Lang::get('balance insufficient'))->error()->livewire($this);
                $this->error = true;
                return;
            }
        } else {
            if ($balanceOne->balance_free < $count) {
                flash(Lang::get('balance insufficient'))->error()->livewire($this);
                $this->error = true;
                return;
            }
        }

        if ($this->orderType == 'buy') {
            $balanceOne->update([
                'balance_use' => $balanceOne->balance_use + ($count * $this->orderPrice),
                'balance_free' => $balanceOne->balance_free - ($count * $this->orderPrice)
            ]);
        } else {
            $balanceTwo->update([
                'balance_use' => $balanceTwo->balance_use + $count,
                'balance_free' => $balanceTwo->balance_free - $count
            ]);
        }
        $marketOrder = $this->marketOrder($count);

        if ($marketOrder) {
            $order = MarketOrder::create([
                'market_id' => $this->orderMarket->id,
                'market_order_id' => $marketOrder['orderId'],
                'user_id' => $userId,
                'count' => $count,
                'remaining' => $count,
                'price' => $this->orderPrice,
                'sumPrice' => $count * $this->orderPrice,
                'type' => $this->orderType,
                'status' => 'init'
            ]);
            $this->emitTo(ActiveOrder::class, 'refreshComponent');
        } else {
            if ($this->orderType == 'buy') {
                $balanceOne->update([
                    'balance_use' => $balanceOne->balance_use - ($count * $this->orderPrice),
                    'balance_free' => $balanceOne->balance_free + ($count * $this->orderPrice)
                ]);
            } else {
                $balanceTwo->update([
                    'balance_use' => $balanceTwo->balance_use - $count,
                    'balance_free' => $balanceTwo->balance_free + $count
                ]);
            }
            flash(Lang::get('the operation failed'))->error()->livewire($this);
        }
    }

    private function marketOrder($count)
    {
        return $this->orderMarket->service()->createOrder($this->orderMarket->symbol, $count, $this->orderPrice, $this->orderType);
    }

    public function matchingMobileWithNational()
    {
        $response = \Inquiry::matchingMobileWithNational([
            'mobile' => $this->user->mobile,
            'nationalCode' => $this->user->national_code,
        ]);
        if ($response['code'] === 200) {
            if ($response['matched']) {
                flash(__('اطلاعات با کد ملی مطابقت دارد'), 'success')->livewire($this);
            } else {
                flash(__('اطلاعات با کد ملی مطابقت ندارد!'), 'error')->livewire($this);
            }
        } else {
            flash(__('نتیجه نامشخص!'), 'error')->livewire($this);
        }
    }
}
