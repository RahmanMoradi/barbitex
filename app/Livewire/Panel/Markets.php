<?php

namespace App\Livewire\Panel;

use App\Helpers\Helper;
use App\Livewire\refreshComponent;
use App\Models\Traid\Market\Market;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Markets extends Component
{
    public $marketsList = [];

    public function getListeners()
    {
//        $prefix = Helper::getBroadcasterPrefix();
//        return [
//            "echo:".$prefix."ticker-update-channels,.App\Events\Binance\GetTicker" => 'UpdatePrice',
//        ];
    }

    public function UpdatePrice($payload)
    {
        $symbol = $payload['ticker']['symbol'];

        $key = array_search($symbol, array_column($this->marketsList, 'symbol'));

        $this->marketsList[$key]['price'] = Helper::formatAmountWithNoE($payload['ticker']['close'], 2);
        $this->marketsList[$key]['change_24'] = $payload['ticker']['percentChange'];
        $this->marketsList[$key]['symbol'] = $payload['ticker']['symbol'];
    }

    public function mount()
    {
        $markets = Market::where('status', 1)->with('currencyBuyer')->get();
        foreach ($markets as $market) {
            $market['currencyBuyer'] = $market->currencyBuyer;
            $market['price'] = $market->currencyBuyer->price;
            $market['change_24'] = $market->currencyBuyer->percent;
            array_push($this->marketsList, $market);
        }
    }

    public function render()
    {
        return view('livewire.panel.markets');
    }

    public function gotoMarket($symbol)
    {
        return redirect(route('market.market', ['market_symbol' => $symbol]));
    }
}
