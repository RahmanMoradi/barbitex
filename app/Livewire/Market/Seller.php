<?php

namespace App\Livewire\Market;

use App\Helpers\Helper;
use App\Livewire\refreshComponent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Seller extends Component
{
    public $seller;

    public function getListeners()
    {
        $prefix = Helper::getBroadcasterPrefix();
        return [
            "echo:".$prefix."ask-bid-channel-{$this->market->symbol},.AskBid" => 'AsksUpdate',
        ];
    }

    public function AsksUpdate($payload)
    {
        if (isset($payload['asks'])) {
            $this->seller = $payload['asks'];
        }
    }

    /**
     * @var mixed
     */
    public $market;

    public function mount($market)
    {
        $this->market = $market;
        $this->seller = Cache::get("$market->symbol-asks", []);
    }

    public function render()
    {
        return view('livewire.market.seller');
    }
}
