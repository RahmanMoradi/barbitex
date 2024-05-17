<?php

namespace App\Livewire\Admin\Wallet;

use App\Livewire\refreshComponent;
use App\Models\Currency\Currency;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Transactions extends Component
{
    use WithPagination, refreshComponent;

    protected $paginationTheme = 'bootstrap';

    public $user_id, $search, $filterUser, $filterCurrency, $filterStatus, $filterType;


    public function mount($user_id = null)
    {
        $this->user_id = $user_id;
    }

    public function render()
    {
        $currencies = Currency::all();
        $users = User::all();
        $increment = 0;
        $decrement = 0;
        if ($this->search || $this->filterUser || $this->filterCurrency || $this->filterStatus || $this->filterType) {
            $wallets = $this->filter();
        } else {
            if ($this->user_id) {
                $wallets = Wallet::where('user_id', $this->user_id)->orderByDesc('created_at')->paginate(10);
                $increment = Wallet::where('user_id', $this->user_id)->where('currency', 'IRT')->where('type', 'increment')->where('status', 'done')->sum('price');
                $decrement = Wallet::where('user_id', $this->user_id)->where('currency', 'IRT')->where('type', 'decrement')->where('status', 'done')->sum('price');
            } else {
                $wallets = Wallet::orderByDesc('created_at')->where('user_id', '!=', 0)->paginate();
            }
        }

        return view('livewire.admin.wallet.transactions', compact('wallets', 'currencies', 'users', 'increment', 'decrement'));
    }

    public function filter()
    {
        if ($this->user_id) {
            return Wallet::where('user_id', $this->user_id)
                ->where('id', 'LIKE', '%' . $this->search . '%')
                ->orWhere('currency', 'LIKE', '%' . $this->search . '%')
                ->orWhere('price', 'LIKE', '%' . $this->search . '%')
                ->orWhere('description', 'LIKE', '%' . $this->search . '%')
                ->orderByDesc('created_at')
                ->paginate(10);
        } else {
            $wallet = \App\Models\Wallet::query();
            if ($this->search) {
                $wallet
                    ->whereHas('user', function ($query) {
                        return $query->where('name', 'LIKE', '%' . $this->search . '%');
                    })
                    ->orWhere('id', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('currency', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('price', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('description', 'LIKE', '%' . $this->search . '%');
            }
            if ($this->filterStatus) {
                $wallet->whereStatus($this->filterStatus);
            }
            if ($this->filterUser) {
                $wallet->whereUserId($this->filterUser);
            }
            if ($this->filterType) {
                $wallet->whereType($this->filterType);
            }

            if ($this->filterCurrency) {
                $wallet->whereCurrency($this->filterCurrency);
            }


            return $wallet->orderByDesc('created_at')->where('user_id', '!=', 0)->paginate();
        }
    }
}
