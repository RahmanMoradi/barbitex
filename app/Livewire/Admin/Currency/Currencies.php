<?php

namespace App\Livewire\Admin\Currency;

use anlutro\LaravelSettings\Facade as Settings;
use App\Livewire\ValidateNotify;
use App\Models\Currency\Currency;
use App\Models\Order\Order;
use App\Models\Traid\Market\Market;
use App\Rules\IsNotPersian;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Currencies extends Component
{
    use WithPagination, WithFileUploads, ValidateNotify;

    public $symbol, $name, $market, $decimal, $icon, $description_buy,
        $description_sell, $search, $currency,
        $dollar_sell_pay_percent, $dollar_buy_pay_percent,
        $currency_sell_pay_percent, $currency_buy_pay_percent,
        $perfectmoney_sell_pay_percent, $perfectmoney_buy_pay_percent,
        $dollar_buy_pay, $dollar_sell_pay, $decimal_size, $chart_name, $explorer, $price, $percent, $class;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->dollar_buy_pay_percent = Settings::get('dollar_buy_pay_percent');
        $this->dollar_sell_pay_percent = Settings::get('dollar_sell_pay_percent');
        $this->currency_buy_pay_percent = Settings::get('currency_buy_pay_percent');
        $this->currency_sell_pay_percent = Settings::get('currency_sell_pay_percent');
        $this->perfectmoney_buy_pay_percent = Settings::get('perfectmoney_buy_pay_percent');
        $this->perfectmoney_sell_pay_percent = Settings::get('perfectmoney_sell_pay_percent');
        $this->dollar_buy_pay = Settings::get('dollar_buy_pay');
        $this->dollar_sell_pay = Settings::get('dollar_sell_pay');
    }

    public function render()
    {
        $currencies = $this->getCurrencies();
        return view('livewire.admin.currency.currencies', compact('currencies'));
    }

    public function edit(Currency $currency)
    {
        $this->currency = $currency;
        $this->symbol = $currency->symbol;
        $this->name = $currency->name;
        $this->price = $currency->price;
        $this->percent = $currency->percent;
        $this->chart_name = $currency->chart_name;
        $this->market = $currency->market;
        $this->decimal = $currency->decimal;
        $this->decimal_size = $currency->decimal_size;
        $this->explorer = $currency->explorer;
        $this->class = $this->market == 'manual' ? '' : 'd-none';
        $this->dispatchBrowserEvent('openEditModal');
    }

    public function update()
    {
        $roles = [
            'symbol' => 'required',
            'name' => 'required',
            'decimal' => 'required',
            'decimal_size' => 'required',
            'market' => 'required',
            'chart_name' => 'nullable',
        ];
        $data = [
            'symbol' => $this->symbol,
            'name' => $this->name,
            'chart_name' => $this->chart_name,
            'decimal' => $this->decimal,
            'decimal_size' => $this->decimal_size,
            'market' => $this->market,
            'price' => $this->price,
            'percent' => $this->percent,
            'explorer' => $this->explorer,
            'icon' => $this->icon ? $this->icon->storePublicly('currency/image', 'public') : $this->currency->icon,
        ];
        $this->validateNotify($data, $roles);
        $this->validate($roles);

        $this->currency->update($data);
        $this->currency->adminUpdate();

        $this->clear();
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
        $this->getCurrencies();
        $this->dispatchBrowserEvent('closeModal');
    }

    public function store()
    {
        $roles = [
            'symbol' => 'required|unique:currencies,symbol',
            'name' => 'required',
            'decimal' => 'required',
            'decimal_size' => 'required',
            'market' => 'required',
            'icon' => 'required|image',
            'chart_name' => 'nullable',
        ];
        $data = [
            'symbol' => $this->symbol,
            'name' => $this->name,
            'decimal' => $this->decimal,
            'decimal_size' => $this->decimal_size,
            'market' => $this->market,
            'icon' => $this->icon,
            'explorer' => $this->explorer,
            'chart_name' => $this->chart_name,
        ];
        $this->validateNotify($data, $roles);
        $this->validate($roles);

        $position = Currency::orderByDesc('position')->first();
        $position = $position ? $position->position + 1 : 1;

        $currency = Currency::create([
            'symbol' => $this->symbol,
            'name' => $this->name,
            'chart_name' => $this->chart_name,
            'market' => $this->market,
            'decimal' => $this->decimal,
            'decimal_size' => $this->decimal_size,
            'explorer' => $this->explorer,
            'price' => 0,
            'position' => $position,
            'count' => 0,
            'icon' => $this->icon->storePublicly('currency/image', 'public'),
        ]);

        $this->clear();
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
        $this->getCurrencies();
        $this->dispatchBrowserEvent('createdCurrency');
    }

    private function getCurrencies()
    {
        if ($this->search) {
            return Currency::where('type', 'coin')
                ->where('symbol', 'LIKE', '%' . $this->search . '%')
                ->orWhere('name', 'LIKE', '%' . $this->search . '%')
                ->orderBy('position')
                ->paginate(20);
        } else {
            return Currency::where('type', 'coin')
                ->orderBy('position')
                ->paginate(20);
        }
    }

    public function filter()
    {
        $this->getCurrencies();
    }

    private function clear()
    {
        $this->symbol = null;
        $this->name = null;
        $this->market = null;
        $this->icon = null;
        $this->decimal = null;
        $this->description_sell = null;
        $this->description_buy = null;
    }

    public function changeActive($active)
    {
        foreach ($this->getCurrencies() as $currency) {
            $currency->update([
                'active' => $active
            ]);
        }
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
    }

    public function changeNetwork()
    {
        foreach ($this->getCurrencies() as $currency) {
            $currency->adminUpdate();
        }
        flash(Lang::get('currency network and border update operation successfully completed'))->success()->livewire($this);
    }

    public function autoUpdate()
    {
        Settings::set('usdAutoUpdate', !Settings::get('usdAutoUpdate'));
        Settings::save();
        flash(Lang::get('price update settings made'))->success()->livewire($this);
    }

    public function changePercent()
    {
        $roule = [
            'dollar_sell_pay_percent' => ['required', new IsNotPersian],
            'dollar_buy_pay_percent' => ['required', new IsNotPersian],
            'currency_sell_pay_percent' => ['required', new IsNotPersian],
            'currency_buy_pay_percent' => ['required', new IsNotPersian],
            'perfectmoney_sell_pay_percent' => ['nullable', new IsNotPersian],
            'perfectmoney_buy_pay_percent' => ['nullable', new IsNotPersian]
        ];
        $data = [
            'dollar_sell_pay_percent' => $this->dollar_sell_pay_percent,
            'dollar_buy_pay_percent' => $this->dollar_buy_pay_percent,
            'currency_sell_pay_percent' => $this->currency_sell_pay_percent,
            'currency_buy_pay_percent' => $this->currency_buy_pay_percent,
            'perfectmoney_sell_pay_percent' => $this->perfectmoney_sell_pay_percent,
            'perfectmoney_buy_pay_percent' => $this->perfectmoney_buy_pay_percent
        ];

        $this->validateNotify($data, $roule);
        $this->validate($roule);

        Settings::set($data);
        Settings::save();

        flash(Lang::get('price update settings made'))->success()->livewire($this);
    }

    public function changePrice()
    {
        $roule = [
            'dollar_buy_pay' => ['required', new IsNotPersian],
            'dollar_sell_pay' => ['required', new IsNotPersian]
        ];
        $data = [
            'dollar_buy_pay' => $this->dollar_buy_pay,
            'dollar_sell_pay' => $this->dollar_sell_pay
        ];
        $this->validateNotify($data, $roule);
        $this->validate($roule);

        Settings::set($data);
        Settings::save();

        flash(Lang::get('price update settings made'))->success()->livewire($this);
    }

    public function changePosition($position)
    {
        $array = explode('-', $position);

        if ($array[0] == 'up') {
            $currency = Currency::find($array[1]);
            $old = Currency::wherePosition($currency->position - 1)->first();
            if ($old) {
                $old->update([
                    'position' => $old->position != null ? $old->position + 1 : $old->id + 1
                ]);
            }
            $currency->update([
                'position' => $currency->position != null ? $currency->position - 1 : $currency->id - 1
            ]);
        } else {
            $currency = Currency::find($array[1]);
            $old = Currency::wherePosition($currency->position + 1)->first();
            if ($old) {
                $old->update([
                    'position' => $old->position != null ? $old->position - 1 : $old->id - 1
                ]);
            }
            $currency->update([
                'position' => $currency->position != null ? $currency->position + 1 : $currency->id + 1
            ]);
        }
    }

    public function delete(Currency $currency)
    {
        $orderCount = Order::where('currency_id', $currency->id)->count();
        $marketcount = Market::where('currency_buy', $currency->id)->orWhere('currency_sell', $currency->id)->count();

        if ($orderCount > 0) {
            flash(Lang::get('it is not possible to delete this currency! this currency has transactions'))->error()->livewire($this);
            return back();
        }

        if ($marketcount > 0) {
            flash(Lang::get('it is not possible to delete this currency! first remove the markets related to this currency'))->error()->livewire($this);
            return back();
        }
        $currency->delete();

        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
    }

    public function changeStatus(Currency $currency)
    {
        $currency->update([
            'active' => !$currency->active
        ]);
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
    }

    public function burnTxids(Currency $currency)
    {
        $currency->service()->burnTxids($currency);
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
    }
}
