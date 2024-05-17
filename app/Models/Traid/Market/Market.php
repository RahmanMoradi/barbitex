<?php

namespace App\Models\Traid\Market;

use App\Models\Currency\Currency;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class Market extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['status_fa', 'status_fa_html', 'decimal'];
    use HasFactory;

    public function currencyBuyer()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_buy');
    }

    public function currencySeller()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_sell');
    }

    public function getStatusFaAttribute()
    {
        if ($this->status) {
            return Lang::get('active');
        }
        return Lang::get('inactive');
    }

    public function getDecimalAttribute()
    {
        return $this->currencyBuyer->decimal;
    }

    public function getStatusFaHtmlAttribute()
    {
        if ($this->status) {
            return "<span class='badge badge-success'>".Lang::get('active')."</span>";
        }
        return "<span class='badge badge-danger'>".Lang::get('inactive')."</span>";
    }

    public function getPriceAttribute()
    {
        return $this->currencyBuyer->price;
    }

    public function getChange24Attribute()
    {
        return $this->currencyBuyer->percent;
    }

    public function service()
    {
        switch ($this->market) {
            case 'binance':
                $service = new \App\Services\Binance();
                break;
            case 'kucoin':
                $service = new \App\Services\Kucoin();
                break;
        }
        return $service;
    }
}
