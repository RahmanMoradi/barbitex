<?php

namespace App\Livewire\Wallet;

use App\Helpers\Helper;
use App\Models\Balance\Balance;
use App\Models\Currency\Currency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use phpDocumentor\Reflection\Types\Collection;

class Wallet extends Component
{
    public $balances, $filter = 0, $search;

    public function mount()
    {
        $this->filterCount();
    }

    public function render()
    {
        return view('livewire.wallet.wallet');
    }

    public function updatedFilter()
    {
        $this->filterCount();
    }

    public function filterCount()
    {
        $currencies = $this->getCurrencies();
        if ($this->filter == 1) {
            $balances = collect();
            foreach ($currencies as $currency) {
                $count = Balance::where('user_id', Auth::id())
                    ->where('currency', $currency->symbol)
                    ->first();

                if ($count && Helper::numberFormatPrecision($count->balance, $currency->decimal) > 0) {
                    $balances->push([
                        'balance' => $count ?: 0,
                        'currency' => $currency
                    ]);
                }
            }

            $this->balances = $balances->all();
        } else {
            $balances = collect();
            foreach ($currencies as $currency) {
                $count = Balance::where('user_id', Auth::id())
                    ->where('currency', $currency->symbol)
                    ->first();
                $balances->push([
                    'balance' => $count ?: 0,
                    'currency' => $currency
                ]);
            }

            $this->balances = $balances->all();
        }
    }

    public function updatedSearch()
    {
        $this->filterCount();
    }

    private function getCurrencies()
    {
        $currencies = Currency::query();
        if (!Helper::modules()['api_version'] === 2) {
            $irt = new Currency();
            $irt->id = 0;
            $irt->symbol = 'IRT';
            $irt->icon = 'currency/image/iran.svg';
            $irt->decimal = 0;
            $irt->name = Lang::get('IRT');
            $irt->price = 0;
        }
        if ($this->search) {
            $currencies = $currencies
                ->where('symbol', 'LIKE', '%' . $this->search . '%')
                ->orWhere('name', 'LIKE', '%' . $this->search . '%');
        }
        $currencies = $currencies->where('active', 1)->get()->sortBy('position');
        if ($this->search && ($this->search == 'IRT' || $this->search == Lang::get('IRT'))) {
            if (!Helper::modules()['api_version'] === 2) {
                $currencies = $currencies->prepend($irt);
            }
        } elseif ($this->search == '') {
            if (!Helper::modules()['api_version'] === 2) {
                $currencies = $currencies->prepend($irt);
            }
        }
        return $currencies;
    }
}
