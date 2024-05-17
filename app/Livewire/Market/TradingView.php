<?php

namespace App\Livewire\Market;

use Livewire\Component;

class TradingView extends Component
{
    /**
     * @var mixed
     */
    public $symbol;
    public $market;

    public function mount($market, $symbol)
    {
        $this->market = $market;
        $this->symbol = $symbol;
    }

    public function render()
    {
        return view('livewire.market.trading-view');
    }
}
