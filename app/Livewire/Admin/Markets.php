<?php

namespace App\Livewire\Admin;

use App\Helpers\Helper;
use App\Livewire\refreshComponent;
use App\Models\Traid\Market\Market;
use Livewire\Component;

class Markets extends Component
{
    use refreshComponent;

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
            array_push($this->marketsList, $market);
        }
    }

    public function render()
    {
        return view('livewire.admin.markets');
    }

    public function gotoMarket($symbol)
    {
        return redirect(route('market.market', ['market_symbol' => $symbol]));
    }
}
