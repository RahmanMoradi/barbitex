<?php

namespace App\Livewire\Wallet;

use anlutro\LaravelSettings\Facade as Settings;
use App\Helpers\Helper;
use App\Livewire\Layout\Loading;
use App\Livewire\ValidateNotify;
use App\Models\Balance\Balance;
use App\Models\Currency\Currency;
use App\Models\Network\Network;
use App\Models\Wallet;
use App\Models\Webazin\PerfectMoney\PerfectMoney;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use \App\Models\Wallet as WalletModel;


class Deposit extends Component
{
    use ValidateNotify;

    public $currency, $symbol, $type, $balance, $description, $networks, $network, $network_id, $txid, $amount, $voucher_code, $voucher_activation_code;

    public $currencyRules = [
        'txid' => 'required',
        'network_id' => 'nullable'
    ];

    /**
     * @var mixed
     */

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
            $this->network_id = $this->network->id;
        }
        if ($symbol == 'PM' || $symbol == 'PMV') {
            $this->type = 'coin';
            $this->currency = Currency::whereSymbol($symbol)->first();
        }
    }

    public function render()
    {
        return view('livewire.wallet.deposit');
    }

    public function submit()
    {
        if ($this->type == 'fiat') {
            return $this->depositFiat();
        } else {
            if ($this->symbol == 'PM') {
                return $this->depositPm();
            }
            return $this->depositCurrency();
        }
    }

    public function changeNetwork()
    {
        $this->network = $this->networks->find($this->network_id);
    }

    public function updatedAmount()
    {
        if ($this->type == 'fiat' || $this->currency->market == 'perfectmoney') {
            $this->amount = number_format(intval(preg_replace('/[^\d. ]/', '', $this->amount)));
        }
    }

    private function depositCurrency()
    {
        if (Helper::CheckTxidFromDb($this->txid)) {
            flash(Lang::get('this transaction has already been registered'))->error()->livewire($this);
            return;
        }
        $dataValidate = [
            'txid' => $this->txid
        ];
        $this->validateNotify($dataValidate, $this->currencyRules);
        $this->validate($this->currencyRules);
        $response = $this->currency->service()->checkDeposit($this->currency, $this->txid);

        if ($response['status'] == 1) {
            $amount = Helper::numberFormatPrecision($response['amount'], $this->currency->decimal);
            $wallet = WalletModel::create([
                'user_id' => Auth::id(),
                'currency' => $this->currency->symbol,
                'price' => $amount,
                'type' => 'increment',
                'status' => Settings::get('autoDeposit') == '1' ? 'done' : 'new',
                'description' => $this->txid
            ]);
            if (Settings::get('autoDeposit') == '1') {
                Balance::createUnique($this->currency->symbol, Auth::user(), $amount);
            }
            flash(Lang::get('operation completed successfully'))->success()->livewire($this);
            $this->mount($this->currency->symbol);
        } else {
            if (isset($response['error'])) {
                flash($response['error'])->error()->livewire($this);
            } else {
                flash(Lang::get('transaction link not found! check the form and resubmit your request'))->error()->livewire($this);
            }
        }
    }

    private function depositFiat()
    {
        $this->amount = intval(preg_replace('/[^\d. ]/', '', $this->amount));
        $roule = [
            'amount' => 'required|numeric|min:50000'
        ];
        $data = [
            'amount' => $this->amount
        ];
        $this->validateNotify($data, $roule);
        $this->validate($roule);
        $wallet = Wallet::create([
            'user_id' => Auth::id(),
            'currency' => $this->symbol,
            'price' => $this->amount,
            'type' => 'increment',
            'description' => Lang::get('deposit fiat by user'),
            'status' => 'process'
        ]);
        try {
            $gateway = \Gateway::make(Helper::get_defult_pay());
            $gateway->setCallback(route('panel.wallet.callback', ['wallet' => $wallet]));
            $gateway->price((int)$this->amount)->ready();
            $refId = $gateway->refId();
            $transID = $gateway->transactionId();

            return $gateway->redirect();
        } catch (Exception $e) {
            flash($e->getMessage())->error()->liviewire($this);
            return back();
        }
    }

    private function depositPm()
    {
        $this->amount = intval(preg_replace('/[^\d. ]/', '', $this->amount));
        $roule = [
            'voucher_code' => 'required|numeric',
            'voucher_activation_code' => 'required|numeric'
        ];
        $data = [
            'voucher_code' => $this->voucher_code,
            'voucher_activation_code' => $this->voucher_activation_code
        ];
        $this->validateNotify($data, $roule);
        $this->validate($roule);
        $prefectMoney = new PerfectMoney();
        $active = $prefectMoney->activeVoucher($this->voucher_code, $this->voucher_activation_code);
        if (isset($active['ERROR'])) {
            flash($active['ERROR'], 'error')->livewire($this);
            return;
        }
        $wallet = Wallet::create([
            'user_id' => Auth::id(),
            'currency' => $this->symbol,
            'price' => $active['VOUCHER_AMOUNT'],
            'type' => 'increment',
            'description' => Lang::get('deposit by user', ['symbol' => $this->symbol]),
            'status' => 'process'
        ]);
        if (Settings::get('autoDeposit') == '1') {
            Balance::createUnique($this->currency->symbol, Auth::user(), $wallet->price);
        }
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
        $this->mount($this->currency->symbol);
        $this->voucher_code = '';
        $this->voucher_activation_code = '';
    }
}
