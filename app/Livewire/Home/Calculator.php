<?php

namespace App\Livewire\Home;

use App\Helpers\Helper;
use App\Models\Currency\Currency;
use Livewire\Component;

class Calculator extends Component
{
    public $currency, $qty, $price;

    protected $rules = [
        'currency' => 'required'
    ];

    public function mount()
    {
        $this->qty = 1;
        $currency = Currency::first();
        $this->currency = $currency ? $currency->id : 0;
        $this->price = number_format($this->qty * ($currency ? $currency->send_price : 0));
    }

    public function render()
    {
        $currencies = Currency::whereActive(1)->get();
        return view('livewire.home.calculator', compact('currencies'));
    }

    public function updatedCurrency()
    {
        $currency = $this->getCurrency();
        $this->price = number_format((float)$this->qty * (float)$currency->send_price);
    }

    public function updatedQty()
    {
        $currency = $this->getCurrency();
        $this->price = number_format((float)$this->qty * $currency->send_price);
    }

    public function updatedPrice()
    {
        $currency = $this->getCurrency();
        $this->qty = Helper::numberFormatPrecision((float)$this->price / $currency->send_price, $currency->decimal);
    }

    private function getCurrency()
    {
        return Currency::find($this->currency);
    }
}
