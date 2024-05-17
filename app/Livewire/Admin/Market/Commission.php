<?php

namespace App\Livewire\Admin\Market;

use App\Models\Balance\Balance;
use App\Models\Wallet;
use Livewire\Component;
use Livewire\WithPagination;

class Commission extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $balances = Balance::where('user_id', 0)->paginate();

        $transactionsDaySumInMarket = $this->getTransactionTimespan()['day'];
        $transactionsMonthSumInMarket = $this->getTransactionTimespan()['mount'];
        $transactionsYearSumInMarket = $this->getTransactionTimespan()['year'];

        $transactionsDaySumInPlane = $this->getTransactionTimespan('plane')['day'];
        $transactionsMonthSumInPlane = $this->getTransactionTimespan('plane')['mount'];
        $transactionsYearSumInPlane = $this->getTransactionTimespan('plane')['year'];

        $transactions = Wallet::where('user_id', 0)->orderByDesc('created_at')->paginate(15, ['*'], 'transactionPage');

        return view('livewire.admin.market.commission', compact('balances', 'transactions', 'transactionsDaySumInMarket',
            'transactionsMonthSumInMarket', 'transactionsYearSumInMarket', 'transactionsDaySumInPlane', 'transactionsMonthSumInPlane', 'transactionsYearSumInPlane'));
    }

    private function getTransactionTimespan($type = 'market')
    {
        $transactionsSumDay = 0;
        $transactionsSumMount = 0;
        $transactionsSumYear = 0;

        if ($type == 'market') {
            $transactionsDay = Wallet::where('user_id', 0)
                ->where('currency', '!=', 'IRT')
                ->whereDay('created_at', date('d'))->get();

            $transactionsMount = Wallet::where('user_id', 0)
                ->where('currency', '!=', 'IRT')
                ->whereMonth('created_at', date('m'))->get();

            $transactionsYear = Wallet::where('user_id', 0)
                ->where('currency', '!=', 'IRT')
                ->whereYear('created_at', date('Y'))->get();

            foreach ($transactionsDay as $transaction) {
                $transactionsSumDay += $transaction->price * optional($transaction->currencyRelation)->price;
            }
            foreach ($transactionsMount as $transaction) {
                $transactionsSumMount += $transaction->price * optional($transaction->currencyRelation)->price;
            }
            foreach ($transactionsYear as $transaction) {
                $transactionsSumYear += $transaction->price * optional($transaction->currencyRelation)->price;
            }

        } else {
            $transactionsDay = Wallet::where('user_id', 0)
                ->where('currency', 'IRT')
                ->whereDay('created_at', date('d'))->get();
            $transactionsMount = Wallet::where('user_id', 0)
                ->where('currency', 'IRT')
                ->whereMonth('created_at', date('m'))->get();

            $transactionsYear = Wallet::where('user_id', 0)
                ->where('currency', 'IRT')
                ->whereYear('created_at', date('Y'))->get();


            foreach ($transactionsDay as $transaction) {
                $transactionsSumDay += $transaction->price;
            }
            foreach ($transactionsMount as $transaction) {
                $transactionsSumMount += $transaction->price;
            }
            foreach ($transactionsYear as $transaction) {
                $transactionsSumYear += $transaction->price;
            }
        }

        return [
            'day' => $transactionsSumDay,
            'mount' => $transactionsSumMount,
            'year' => $transactionsSumYear
        ];
    }
}
