<?php

namespace App\Livewire\Admin\Market;

use App\Helpers\Helper;
use App\Livewire\ValidateNotify;
use App\Models\Currency\Currency;
use App\Models\Traid\Market\Market;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redis;
use Livewire\Component;
use phpseclib\Net\SSH2;

class Markets extends Component
{
    use ValidateNotify;

    public $form, $buyCurrencies, $sellCurrencies, $currency_buy, $currency_sell, $market, $status, $symbol, $marketEdit, $marketsList = [];

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

        $key = array_search($symbol, array_column($this->marketsList, 'symbol'));
        $this->marketsList[$key]['price'] = $payload['ticker']['close'];
        $this->marketsList[$key]['change_24'] = $payload['ticker']['percentChange'];
        $this->marketsList[$key]['symbol'] = $payload['ticker']['symbol'];
    }

    public function mount()
    {
        $this->buyCurrencies = Currency::whereNotIn('symbol', ['USDT', 'IRT', 'PM'])
            ->where('market', '!=', 'manual')
            ->where('active', 1)
            ->get();
        $this->sellCurrencies = Currency::whereIn('symbol', ['USDT'])->get();
        $markets = Market::with('currencyBuyer')->orderBy('created_at')->get();
        foreach ($markets as $market) {
            $market['currencyBuyer'] = $market->currencyBuyer;
            $market['price'] = $market->currencyBuyer->price;
            $market['change_24'] = $market->currencyBuyer->percent;
            array_push($this->marketsList, $market);
        }
    }

    public function render()
    {
        return view('livewire.admin.market.markets');
    }

    public function edit(Market $market)
    {
        $this->currency_buy = $market->currency_buy;
        $this->currency_sell = $market->currency_sell;
        $this->market = $market->market;
        $this->status = $market->status;
        $this->symbol = $market->symbol;
        $this->marketEdit = $market;
        $this->dispatchBrowserEvent('openEditModal');
    }

    public function update(Market $market)
    {
        $this->validForm();
        $data = [
            'currency_buy' => $this->currency_buy,
            'currency_sell' => $this->currency_sell,
            'market' => $this->market,
            'status' => $this->status,
            'symbol' => $this->symbol,
        ];
        $market->update($data);
        $this->clearForm();
        $this->dispatchBrowserEvent('closeModal');
        $this->addMarketToRedis();
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
    }

    public function store()
    {
        $data = [
            'currency_buy' => $this->currency_buy,
            'currency_sell' => $this->currency_sell,
            'market' => $this->market,
            'status' => $this->status,
            'symbol' => $this->symbol,
        ];
        $this->validForm();
        $check = Market::where('currency_buy', $this->currency_buy)->where('currency_sell', $this->currency_sell)->first();
        if ($check) {
            flash(Lang::get('this market has already been created'))->error()->livewire($this);
            return;
        }
        Market::create($data);
        $this->clearForm();
        $this->dispatchBrowserEvent('closeModal');
        $this->addMarketToRedis();
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
    }

    public function changeStatus(Market $market)
    {
        $market->update([
            'status' => !$market->status
        ]);
        $this->render();
        $this->addMarketToRedis();
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
    }

    public function delete(Market $market)
    {
        $market->delete();
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
    }

    public function deleteAll()
    {
        $allMarkets = Market::all();
        foreach ($allMarkets as $market) {
            $market->delete();
        }
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
    }

    public function changeStatusAll($status)
    {
        $allMarkets = Market::all();
        foreach ($allMarkets as $market) {
            $market->update([
                'status' => $status
            ]);
        }
        $this->render();
        $this->addMarketToRedis();
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
    }

    private function clearForm()
    {
        $this->currency_buy = null;
        $this->currency_sell = null;
        $this->market = null;
        $this->status = null;
        $this->symbol = null;
    }

    private function validForm()
    {
        $role = [
            'currency_buy' => 'required',
            'currency_sell' => 'required',
            'market' => 'required',
            'status' => 'required',
            'symbol' => 'required',
        ];
        $data = [
            'currency_buy' => $this->currency_buy,
            'currency_sell' => $this->currency_sell,
            'market' => $this->market,
            'status' => $this->status,
            'symbol' => $this->symbol,
        ];

        $this->validateNotify($data, $role);
        $this->validate($role);
    }

    public function addMarketToRedis()
    {
        Artisan::call('market:addToRedis');
    }
}
