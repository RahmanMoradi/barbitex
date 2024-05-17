<?php

namespace App\Livewire\Wallet;

use anlutro\LaravelSettings\Facade as Settings;
use App\Livewire\Admin\Wallet\DecrementRequest;
use App\Livewire\Layout\Sidebar;
use App\Livewire\ValidateNotify;
use App\Models\Balance\Balance;
use App\Models\Card\Card;
use App\Models\Currency\Currency;
use App\Models\Network\Network;
use App\Models\Wallet;
use App\Services\Binance;
use App\Services\Btc;
use App\Services\Doge;
use App\Services\Eth;
use App\Services\Kucoin;
use App\Services\Ltc;
use App\Services\Tron;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class Withdraw extends Component
{
    use ValidateNotify;

    public $currency, $balance, $amount, $walletData,
        $description, $cards, $wallet, $network, $networks,
        $tag, $txid, $network_id, $symbol, $type, $card_id, $pmType = 'perfectmoney';

    protected $rules = [
        'amount' => 'required|numeric|min:50000',
        'card_id' => 'required|exists:cards,id'
    ];

    protected $rulesCurrency = [
        'amount' => 'required|numeric',
        'wallet' => 'required',
    ];

    protected $rulesPm = [
        'amount' => 'required|numeric',
        'wallet' => 'required_if:pmType,perfectmoney',
    ];

    public function mount($symbol)
    {
        if ($symbol != 'IRT' & $symbol != 'PM' & $symbol != 'PMV') {
            $this->currency = Currency::whereSymbol($symbol)->first();
            $this->type = 'coin';
        } else {
            $this->type = 'fiat';
            $this->symbol = $symbol;
        }
        $balance = Balance::where('currency', $symbol)
            ->where('user_id', Auth::id())->first();
        $this->balance = $balance ? $balance->balance_free : 0;
        if ($symbol != 'IRT' & $symbol != 'PM' & $symbol != 'PMV') {
            $this->networks = $this->currency->networks;
            $this->network = $this->currency->networks->where('isDefault', 1)->first();
        }
        $this->amount = null;
        $this->card_id = null;
        $this->wallet = null;

        if ($symbol == 'PM' || $symbol == 'PMV') {
            $this->type = 'coin';
            $this->currency = Currency::whereSymbol($symbol)->first();
        }
    }

    public function render()
    {
        return view('livewire.wallet.withdraw');
    }

    public function updatedAmount()
    {
        if ($this->type == 'fiat') {
            $this->amount = number_format(intval(preg_replace('/[^\d. ]/', '', $this->amount)));
        }
    }

    public function changeNetwork()
    {
        $this->network = $this->networks->find($this->network_id);
    }

    public function submit()
    {
        $this->amount = intval(preg_replace('/[^\d. ]/', '', $this->amount));
        $data = [
            'amount' => $this->amount,
            'card_id' => $this->card_id,
        ];
        $this->validateNotify($data, $this->rules);
        $this->validate();

        if ($this->amount > $this->balance) {
            flash(Lang::get('balance insufficient'))->error()->livewire($this);

            return back();
        }
        $wage = 0;
        if (Settings::get('withdraw_irt_fee') && Settings::get('withdraw_irt_fee') > 0) {
            $wage = -Settings::get('withdraw_irt_fee');
            Wallet::create([
                'user_id' => Auth::id(),
                'card_id' => $this->card_id,
                'currency' => $this->symbol,
                'price' => $wage,
                'type' => 'decrement',
                'status' => 'done',
                'description' => Lang::get('wage for withdraw')
            ]);
            Balance::createUnique($this->symbol, Auth::user(), $wage);
        }
        Wallet::create([
            'user_id' => Auth::id(),
            'card_id' => $this->card_id,
            'currency' => $this->symbol,
            'price' => -($this->amount + $wage),
            'type' => 'decrement',
            'status' => 'new',
            'description' => Lang::get('withdraw by user')
        ]);
        Balance::createUnique($this->symbol, Auth::user(), -($this->amount + $wage));

        $this->successNotify();
    }

    public function submitCurrency()
    {
        if ($this->currency->market == 'perfectmoney') {
            return $this->submitPm();
        }
        $data = [
            'amount' => $this->amount,
            'wallet' => $this->wallet
        ];
        $this->validateNotify($data, $this->rulesCurrency);
        $this->validate($this->rulesCurrency);
        if ($this->amount > $this->balance) {
            flash(Lang::get('balance insufficient'))->error()->livewire($this);
            return;
        }
        if ($this->network->withdrawMin > $this->amount) {
            flash(Lang::get('min in network', ['name' => $this->network->coin, 'network' => $this->network->network, 'min' => $this->network->withdrawMin]))->error()->livewire($this);
            return;
        }

        $this->withdraw();
    }

    private function withdraw()
    {
        try {

            $wallet = Wallet::create([
                'user_id' => Auth::id(),
                'network_id' => $this->currency->market == 'perfectmoney' ? null : $this->network->id,
                'currency' => $this->currency->symbol,
                'price' => -$this->amount,
                'type' => 'decrement',
                'status' => Settings::get('autoWithdraw') == '1' ? 'done' : 'new',
                'wallet' => $this->wallet . ($this->tag ? '|' . $this->tag : ''),
                'description' => $this->txid,
                'service_id' => $this->currency->market == 'perfectmoney' ? $this->pmType : null,
            ]);
            Balance::createUnique($this->currency->symbol, Auth::user(), -$this->amount);
            if (Settings::get('autoWithdraw') == '1') {
                $this->withdrawFromMarket($wallet);
            }
            $this->successNotify();
        } catch (\Exception $exception) {
            flash($exception->getMessage())->error()->livewire($this);
        }
    }

    private function addTxid($user_id, $symbol, $txid)
    {
        DB::table('txids')->insert([
            'user_id' => $user_id,
            'symbol' => $symbol,
            'txid' => $txid
        ]);
    }

    private function withdrawFromMarket(Wallet $wallet)
    {
        $wallet->update([
            'admin_id' => 0
        ]);
        $this->currency->service()->withdraw($wallet);
    }

    public function clear()
    {
        $this->amount = null;
        $this->wallet = null;
    }

    private function successNotify()
    {
        flash(Lang::get('your request has been successfully registered'))->success()->livewire($this);
        $this->mount($this->symbol);
        $this->emitTo(Sidebar::class, 'refreshComponent');
        $this->emitTo(DecrementRequest::class, 'refreshComponent');
    }

    private function submitPm()
    {
        $data = [
            'amount' => $this->amount,
            'wallet' => $this->wallet,
            'pmType' => $this->pmType
        ];
        $this->validateNotify($data, $this->rulesPm);
        $this->validate($this->rulesPm);
        if ($this->amount > $this->balance) {
            flash(Lang::get('balance insufficient'))->error()->livewire($this);
            return;
        }
        if (1 > $this->amount) {
            flash(Lang::get('min in network', ['name' => 'pm', 'network' => 'pm', 'min' => 1]))->error()->livewire($this);
            return;
        }

        $this->withdraw();
    }
}
