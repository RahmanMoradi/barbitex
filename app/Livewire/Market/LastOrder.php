<?php

namespace App\Livewire\Market;

use App\Helpers\Helper;
use App\Livewire\refreshComponent;
use App\Models\Traid\Market\MarketOrder;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class LastOrder extends Component
{
    public $market;
    /**
     * @var array
     */
    public $lastOrders;

    public function getListeners()
    {
        $prefix = Helper::getBroadcasterPrefix();
        return [
            "echo:".$prefix."get-last-order-{$this->market->symbol},.App\Events\Binance\GetLastOrdersEvent" => 'UpdateLastOrders',
        ];
    }

    public function UpdateLastOrders($payload)
    {
        $this->lastOrders[] = $payload['trades'];
//        array_push($this->lastOrders, $payload['trades']);
//        dd($this->lastOrders);
//        $this->lastOrders[] = $payload['trades'];
//        dd($this->lastOrders);
        $symbol = $this->market->symbol;
    }

    public function mount(\App\Models\Traid\Market\Market $market)
    {
        $this->market = $market;
        $this->lastOrders = Cache::get("$market->symbol-lastOrders", []);
        $this->lastOrders = [];
    }

    public function render()
    {
        return view('livewire.market.last-order');
    }
}
