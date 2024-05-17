<?php

namespace App\Livewire\Wallet;

use App\Models\Currency\Currency;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Transactions extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search, $filterCurrency, $filterStatus, $filterType;

    public function render()
    {
        $currencies = Currency::all();
        if ($this->search || $this->filterCurrency || $this->filterStatus || $this->filterType) {
            $transactions = $this->filter();
        } else {
            $transactions = \App\Models\Wallet::where('user_id', Auth::id())->orderByDesc('created_at')->paginate();
        }
        return view('livewire.wallet.transactions', compact('transactions', 'currencies'));
    }

    private function filter()
    {
        $wallet = \App\Models\Wallet::query();
        if ($this->search) {
            $wallet->where('currency', 'LIKE', '%' . $this->search . '%')
                ->orWhere('price', 'LIKE', '%' . $this->search . '%')
                ->orWhere('description', 'LIKE', '%' . $this->search . '%');
        }
        if ($this->filterStatus) {
            $wallet->whereStatus($this->filterStatus);
        }
        if ($this->filterType) {
            $wallet->whereType($this->filterType);
        }

        if ($this->filterCurrency) {
            $wallet->whereCurrency($this->filterCurrency);
        }


        return $wallet->where('user_id', Auth::id())->orderByDesc('created_at')->paginate();

    }
}
