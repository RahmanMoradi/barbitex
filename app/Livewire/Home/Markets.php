<?php

namespace App\Livewire\Home;

use App\Helpers\Helper;
use App\Models\Currency\Currency;
use App\Models\Traid\Market\Market;
use Livewire\Component;

class Markets extends Component
{
    public $marketsSlider = [];

    public function getListeners()
    {
//        $prefix = Helper::getBroadcasterPrefix();
//        return [
//            "echo:" . $prefix . "ticker-update-channels,.App\Events\Binance\GetTicker" => 'UpdatePrice',
//        ];
    }

    public function UpdatePrice($payload)
    {
        $symbol = $payload['ticker']['symbol'];

        $key = array_search($symbol, array_column($this->marketsSlider, 'symbol'));

        if ((string)$key != "") {
            $this->marketsSlider[$key]['price'] = $payload['ticker']['close'];
            $this->marketsSlider[$key]['change_24'] = $payload['ticker']['percentChange'];
            $this->marketsSlider[$key]['symbol'] = $payload['ticker']['symbol'];
        }
    }

    public function mount()
    {
        $markets = Currency::where('active', 1)->take(6)->get();
        $this->marketsSlider = $markets;

    }

    public function render()
    {
        return view('livewire.home.markets');
    }
}
