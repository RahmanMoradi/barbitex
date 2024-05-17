<?php

namespace App\Livewire\Panel;

use App\Models\Currency\Currency;
use Livewire\Component;

class CurrenciesSlider extends Component
{
    public $currencies;

    public function mount()
    {
        $this->currencies = Currency::whereType('coin')->where('active', true)
            ->where('percent', '>', 0)
            ->orderByRaw('CONVERT(percent, SIGNED) desc')
            ->take(15)->get();
    }

    public function render()
    {
        return view('livewire.panel.currencies-slider');
    }
}
