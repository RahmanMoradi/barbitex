<?php

namespace App\Livewire\Wallet;

use anlutro\LaravelSettings\Facade as Settings;
use App\Livewire\ValidateNotify;
use App\Models\Balance\Balance;
use App\Models\Currency\Currency;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Transfer extends Component
{
    use ValidateNotify;

    public $currency, $symbol, $balance, $amount, $user_id;
    protected $queryString = ['symbol'];

    public function mount()
    {
        $this->currency = Currency::whereSymbol($this->symbol)->first();
        $balance = Balance::where('currency', $this->symbol)
            ->where('user_id', Auth::id())->first();
        $this->balance = $balance ? $balance->balance_free : 0;
    }

    public function render()
    {
        return view('livewire.wallet.transfer');
    }

    public function transfer()
    {
        $data = [
            'user_id' => $this->user_id,
            'amount' => $this->amount
        ];
        $rules = [
            'user_id' => 'required|numeric|exists:users,id',
            'amount' => 'required|numeric'
        ];
        $this->validateNotify($data, $rules);
        $this->validate($rules);
        if ($this->amount > $this->balance) {
            flash(__('balance insufficient'), 'error')->livewire($this);

            return back();
        }
        try {
            \DB::transaction(function () {
                Wallet::create([
                    'user_id' => Auth::id(),
                    'currency' => $this->currency->symbol,
                    'price' => -$this->amount,
                    'type' => 'decrement',
                    'status' => 'done',
                    'wallet' => $this->user_id,
                    'description' => __('global transfer to', ['user_id' => $this->user_id]),
                ]);
                Balance::createUnique($this->currency->symbol, Auth::user(), -$this->amount);

                Wallet::create([
                    'user_id' => $this->user_id,
                    'currency' => $this->currency->symbol,
                    'price' => $this->amount,
                    'type' => 'increment',
                    'status' => 'done',
                    'wallet' => Auth::id(),
                    'description' => __('global transfer from', ['user_id' => Auth::id()]),
                ]);

                Balance::createUnique($this->currency->symbol, User::find($this->user_id), $this->amount);

                flash(__('operation completed successfully'), 'success')->livewire($this);
            });
        } catch (\Exception $exception) {
            flash($exception->getMessage(), 'error')->livewire($this);
            \DB::rollBack();
        }
        $balance = Balance::where('currency', $this->symbol)
            ->where('user_id', Auth::id())->first();
        $this->balance = $balance ? $balance->balance_free : 0;
        $this->amount = null;
        $this->user_id = null;
    }
}
