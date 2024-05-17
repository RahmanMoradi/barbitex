<?php

namespace App\Livewire\Panel;

use anlutro\LaravelSettings\Facade as Settings;
use App\Helpers\Helper;
use App\Models\Balance\Balance;
use App\Models\Currency\Currency;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BalanceChart extends Component
{
    public $balance;

    public function mount()
    {
        $balanceDb = Balance::where('user_id', Auth::id())
            ->where('balance_free', '>', 0)->get();
        $this->balance = [];
        foreach ($balanceDb as $item) {
            if ($item->currency == 'IRT') {
                $data = [
                    'currency' => $item->currency,
                    'balance' => $item->balance_free,
                    'balanceIrt' => Helper::numberFormatPrecision($item->balance,0)
                ];
            } else {
                $data = [
                    'currency' => $item->currency,
                    'balance' => $item->balance_free,
                    'balanceIrt' => Helper::numberFormatPrecision($item->balance_free * (optional($item->currencyModel)->price * Settings::get('dollar_sell_pay')),0)
                ];
            }
            array_push($this->balance, $data);
        }
        if (count($this->balance) == 0) {
            $this->balance = [
                [
                    'currency' => 'IRT',
                    'balance' => 0,
                    'balanceIrt' => 0
                ]
            ];
        }
    }

    public function render()
    {
        return view('livewire.panel.balance-chart');
    }
}
