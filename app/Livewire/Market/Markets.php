<?php

namespace App\Livewire\Market;

use App\Helpers\Helper;
use App\Livewire\refreshComponent;
use App\Models\Currency\Currency;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Livewire\Component;

class Markets extends Component
{
    public $marketsList = [], $marketActive, $search;

    public function getListeners()
    {
        $prefix = Helper::getBroadcasterPrefix();
        return [
            "echo:" . $prefix . "ticker-update-channels,.App\Events\Binance\GetTicker" => 'UpdatePrice',
            'refreshComponent' => '$refresh'
        ];
    }

    public function UpdatePrice($payload)
    {
        $symbol = $payload['ticker']['symbol'];
        if ($this->search) {
            if (!str_contains($symbol, $this->search)) {
                return;
            }
        }

        $key = array_search($symbol, array_column($this->marketsList, 'symbol'));

        $this->marketsList[$key]['price'] = Helper::formatAmountWithNoE($payload['ticker']['close'], 2);
        $this->marketsList[$key]['change_24'] = $payload['ticker']['percentChange'];
        $this->marketsList[$key]['symbol'] = $payload['ticker']['symbol'];
//        Cache::put("marketsList", $this->marketsList);
    }

    public function render()
    {
        return view('livewire.market.markets');
    }

    public function mount($market)
    {
        $this->marketActive = $market;
        $this->getMarkets();
    }

    public function gotoMarket($symbol)
    {
        return redirect(route('market.market', ['market_symbol' => $symbol]));
    }

    public function filter()
    {
        $this->getMarkets();
    }

    private function getMarkets()
    {
        if ($this->search) {
            $key = array_search(strtoupper($this->search), array_column($this->marketsList, 'symbol'));
            if ($key) {
                $this->marketsList = $this->marketsList[$key];
            } else {
                $this->marketsList = [];
            }
        } else {
            $this->marketsList = \App\Models\Traid\Market\Market::where('status', 1)->orderBy('created_at')->get()->toArray();
        }
    }
}

