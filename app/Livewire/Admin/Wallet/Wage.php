<?php

namespace App\Livewire\Admin\Wallet;

use App\Models\Balance\Balance;
use App\Models\Wallet;
use Livewire\Component;
use Livewire\WithPagination;

class Wage extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $transactions = Wallet::where('user_id', 0)->orderBy('created_at', 'DESC')->paginate();
        $balances = Balance::where('user_id', 0)->paginate();

        return view('livewire.admin.wallet.wage', compact('transactions', 'balances'));
    }
}
