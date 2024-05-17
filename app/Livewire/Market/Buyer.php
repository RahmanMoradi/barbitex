<?php

namespace App\Livewire\Market;

use App\Helpers\Helper;
use App\Livewire\refreshComponent;
use App\Models\Webazin\Binance\Facades\Binance;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Buyer extends Component
{
    public $market;
    public $buyer;

//    use refreshComponent;

    public function getListeners()
    {
        $prefix = Helper::getBroadcasterPrefix();
        return [
            "echo:".$prefix."ask-bid-channel-{$this->market->symbol},.AskBid" => 'BidsUpdate',
        ];
    }

    public function BidsUpdate($payload)
    {
        if (isset($payload['bids'])) {
            $this->buyer = $payload['bids'];
        }
    }

    public function mount($market)
    {
        $this->buyer = Cache::get("$market->symbol-bids", []);
        $this->market = $market;
    }

    public function render()
    {
        return view('livewire.market.buyer');
    }
}
