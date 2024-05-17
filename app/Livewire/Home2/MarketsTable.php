<?php

namespace App\Livewire\Home2;

use App\Models\Currency\Currency;
use App\Models\Traid\Market\Market;
use Livewire\Component;

class MarketsTable extends Component
{
    public $filter;
    public function render()
    {
        $marketsTable = $this->getMarkets();
        return view('livewire.home2.markets-table',compact('marketsTable'));
    }

    private function getMarkets()
    {
        $markets = Currency::query();
        if ($this->filter) {
            $markets = $markets
                ->where('symbol','LIKE','%'.$this->filter.'%')
                ->orWhere('name','LIKE','%'.$this->filter.'%');
        }

        return $markets->where('active', 1)->paginate();
    }
}
