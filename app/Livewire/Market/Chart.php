<?php

namespace App\Livewire\Market;

use App\Helpers\Helper;
use App\Livewire\refreshComponent;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Chart extends Component
{
    public $market;
    public $high;
    public $low;
    public $close;
    public $volume;

    public function getListeners()
    {
        $prefix = Helper::getBroadcasterPrefix();
        return [
            "echo:".$prefix."ticker-update-channels,.App\Events\Binance\GetTicker" => 'TickerUpdate',
        ];
    }

    public function TickerUpdate($payload)
    {
        if ($payload['symbol'] == $this->market->symbol) {
            $this->high = Helper::formatAmountWithNoE($payload['ticker']['high'],2);
            $this->low = Helper::formatAmountWithNoE($payload['ticker']['low'],2);
            $this->close = Helper::formatAmountWithNoE($payload['ticker']['close'],2);
            $this->volume = $payload['ticker']['volume'];
        }
    }

    public function mount(\App\Models\Traid\Market\Market $market)
    {
        $this->market = $market;
        $ticker = Cache::get("$market->symbol-ticker", null);
        if ($ticker) {
            $this->high = $ticker['high'];
            $this->low = $ticker['low'];
            $this->close = $ticker['close'];
            $this->volume = $ticker['volume'];
        }
    }

    public function render()
    {
        return view('livewire.market.chart');
    }
}
