<?php

namespace App\Livewire\Home;

use App\Helpers\Helper;
use App\Models\Currency\Currency;
use App\Models\Traid\Market\Market;
use Livewire\Component;
use Livewire\WithPagination;

class MarketsTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $marketsTable;
    public $marketsList = [];

    public function getListeners()
    {
//        $prefix = Helper::getBroadcasterPrefix();
//
//        return [
//            "echo:" . $prefix . "ticker-update-channels,.App\Events\Binance\GetTicker" => 'UpdatePrice',
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
        $markets = Currency::where('active', 1)->orderBy('created_at')->get();
        $this->marketsList = $markets;

    }

    public function render()
    {
        return view('livewire.home.markets-table');
    }
}
