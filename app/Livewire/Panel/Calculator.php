<?php

namespace App\Livewire\Panel;

use App\Models\Currency\Currency;
use Livewire\Component;

class Calculator extends Component
{
    public $currencies, $symbol, $currency, $qty, $price;

    protected $rules = [
        'currency' => 'required',
        'qty' => 'required'
    ];

    public function mount()
    {
        $this->currencies = Currency::where('active', 1)->get();
        $this->currency = $this->currencies[0];
        $this->symbol = $this->currencies[0]->symbol;
    }

    public function render()
    {
        return view('livewire.panel.calculator');
    }

    public function updatedSymbol()
    {
        $this->currency = Currency::whereSymbol($this->symbol)->first();
        $this->price = number_format($this->qty * $this->currency->irtPrice);
    }

    public function updatedQty()
    {
        $this->price = number_format($this->qty * $this->currency->irtPrice);
    }

    public function submit($type)
    {
        return $this->redirectRoute('order.create', ['currency' => $this->symbol, 'type' => $type, 'qty' => $this->qty]);
    }
}
