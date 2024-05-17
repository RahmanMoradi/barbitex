<?php

namespace App\Livewire\Panel;

use App\Models\Currency\Currency;
use Livewire\Component;
use Livewire\WithPagination;

class Currencies extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    /**
     * @var mixed
     */
    public $search;

    public function render()
    {
        $currencies = $this->getCurrencies();
        return view('livewire.panel.currencies', compact('currencies'));
    }

    private function getCurrencies()
    {
        $currency = Currency::query();
        if ($this->search) {
            $currency
                ->where('symbol', 'LIKE', '%' . $this->search . '%')
                ->orWhere('name', 'LIKE', '%' . $this->search . '%');
        }

        return $currency->where('type', 'coin')->where('active',1)->orderBy('position')->paginate(20);
    }
}
