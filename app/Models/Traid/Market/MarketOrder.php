<?php

namespace App\Models\Traid\Market;

use anlutro\LaravelSettings\Facade as Settings;
use App\Events\Market\BalanceUpdateEvent;
use App\Models\Balance\Balance;
use App\Models\Currency\Currency;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;
use Morilog\Jalali\Jalalian;

class MarketOrder extends Model
{
    use HasFactory, MarketOrderEvent;

    protected $guarded = ['id'];
    protected $appends = ['created_at_fa', 'status_fa_html', 'type_fa_html', 'status_fa_text', 'type_fa_text'];

    public function getCreatedAtFaAttribute()
    {
        return Jalalian::forge($this->created_at)->format('Y-m-d H:m');
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusFaHtmlAttribute()
    {
        switch ($this->status) {
            case 'init':
                return "<span class='badge badge-primary'>" . Lang::get('open') . "</span>";
            case 'done':
                return "<span class='badge badge-success'>" . Lang::get('done') . "</span>";
            case 'cancel':
                return "<span class='badge badge-danger'>" . Lang::get('canceled') . "</span>";
        }
    }

    public function getTypeFaHtmlAttribute()
    {
        if ($this->type == 'sell') {
            return "<span class='badge badge-danger'>".Lang::get('sell')."</span>";
        } else {
            return "<span class='badge badge-success'>".Lang::get('buy')."</span>";
        }
    }

    public function getStatusFaTextAttribute()
    {
        switch ($this->status) {
            case 'init':
                return Lang::get('open');
            case 'done':
                return Lang::get('done');
            case 'cancel':
                return Lang::get('canceled');
        }
    }

    public function getTypeFaTextAttribute()
    {
        if ($this->type == 'sell') {
            return Lang::get('sell');
        } else {
            return Lang::get('buy');
        }
    }
}
