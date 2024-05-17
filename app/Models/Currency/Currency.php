<?php

namespace App\Models\Currency;

use anlutro\LaravelSettings\Facade as Setting;
use anlutro\LaravelSettings\Facade as Settings;
use App\Helpers\Helper;
use App\Models\Network\Network;
use App\Models\Traid\Market\Market;
use App\Services\Binance;
use App\Services\Kucoin;
use App\Services\Manual;
use App\Services\Mexc;
use App\Services\PerfectMoney;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory, CurrencyEvents;

    protected $observables = [
        'adminUpdated',
    ];

    protected $casts = [
        'position' => 'integer',
        //        'price' => 'float'
    ];

    protected $appends = ['iconUrl', 'irt_price', 'send_price', 'receive_price', 'percent_image', 'chart_image', 'sell_percent', 'buy_percent'];
    protected $guarded = ['id'];

    public function networks()
    {
        return $this->hasMany(Network::class, 'coin', 'symbol')->where('active', 1);
    }

    public function getIconUrlAttribute()
    {
        return asset('uploads/' . $this->icon);
    }

    public function getIrtPriceAttribute()
    {
        $percent = Setting::get('dollar_sell_pay_percent');
        if ($this->symbol != 'USDT') {
            $percent = Setting::get('currency_sell_pay_percent');
        }

        $price = (Setting::get('dollar_sell_pay') * $this->price);

        //        $price = (($price * $percent) / 100 + $price);

        if ($this->price < 0.005) {
            for ($i = 3; $i < 10; $i++) {
                $newPrice = Helper::numberFormatPrecision($price, $i);
                if ($newPrice > 0) {
                    return $newPrice;
                }
            }
        }

        return Helper::numberFormatPrecision($price, 0);
    }

    public function getSellPercentAttribute()
    {
        $percent = Setting::get('dollar_sell_pay_percent');
        if ($this->symbol != 'USDT') {
            $percent = Setting::get('currency_sell_pay_percent');
        }
        return $percent;
    }

    public function getBuyPercentAttribute()
    {
        $percent = Setting::get('dollar_buy_pay_percent');
        if ($this->symbol != 'USDT') {
            $percent = Setting::get('currency_buy_pay_percent');
        }
        return $percent;
    }

    public function getSendPriceAttribute()
    {
        $percent = Setting::get('dollar_sell_pay_percent');
        if ($this->symbol != 'USDT') {
            $percent = Setting::get('currency_sell_pay_percent');
            if ($this->symbol == 'PM') {
                $percent = Setting::get('perfectmoney_sell_pay_percent');
            }
        }

        $price = (Setting::get('dollar_sell_pay') * $this->price);

        $price = (($price * $percent) / 100 + $price);

        if ($this->price < 0.005) {
            for ($i = 3; $i < 10; $i++) {
                $newPrice = Helper::numberFormatPrecision($price, $i);
                if ($newPrice > 0) {
                    return $newPrice;
                }
            }
        }

        return Helper::numberFormatPrecision($price, 0);
    }

    public function getReceivePriceAttribute()
    {
        $percent = Setting::get('dollar_buy_pay_percent');
        if ($this->symbol != 'USDT') {
            $percent = Setting::get('currency_buy_pay_percent');
            if ($this->symbol == 'PM') {
                $percent = Setting::get('perfectmoney_buy_pay_percent');
            }
        }

        $price = (Setting::get('dollar_buy_pay') * $this->price);

        $price = - (($price * $percent) / 100 - $price);

        if ($this->price < 0.005) {
            for ($i = 3; $i < 10; $i++) {
                $newPrice = Helper::numberFormatPrecision($price, $i);
                if ($newPrice > 0) {
                    return $newPrice;
                }
            }
        }
        return Helper::numberFormatPrecision($price, 0);
    }

    public function service()
    {
        switch ($this->market) {
            case 'binance':
                return new Binance();
            case 'kucoin':
                return new Kucoin();
            case 'mexc':
                return new Mexc();
            case 'manual':
                return new Manual();
            case 'perfectmoney':
                return new PerfectMoney();
        }
    }

    public function markets()
    {
        return $this->hasMany(Market::class, 'currency_buy', 'id');
    }

    public function defaultMarket()
    {
        return $this->hasOne(Market::class, 'currency_buy', 'id');
    }

    public function getChartImageAttribute()
    {
        $name = $this->chart_name;
        $time = Carbon::now()->timestamp;
        return "https://cdn.arzdigital.com/uploads/assets/coins/charts/$name?t=$time";
    }

    public function getPercentImageAttribute()
    {
        if ($this->percent == 0) {
            return "<i class='fa fa-stop'></i>";
        }
        return $this->percent < 0 ? "<i class='fa fa-arrow-down'></i>" : "<i class='fa fa-arrow-up'></i>";
    }
}
