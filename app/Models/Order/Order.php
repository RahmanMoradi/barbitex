<?php

namespace App\Models\Order;

use App\Models\Currency\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;
use Morilog\Jalali\Jalalian;

class Order extends Model
{
    use HasFactory, OrderEvent;

    protected $guarded = ['id'];
    protected $appends = ['status_fa_html', 'type_fa_html', 'status_color', 'status_text', 'type_text', 'created_at_fa'];


    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusFaHtmlAttribute()
    {
        switch ($this->status) {
            case 'new':
                return "<span class='badge badge-info'>".Lang::get('new')."</span>";
            case 'done':
                return "<span class='badge badge-success'>".Lang::get('done')."</span>";
            case 'process':
                return "<span class='badge badge-primary'>".Lang::get('doing')."</span>";
            case 'cancel':
                return "<span class='badge badge-danger'>".Lang::get('failed')."</span>";
        }
    }

    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 'new':
                return "blue";
            case 'done':
                return "green";
            case 'process':
                return "yellow";
            case 'cancel':
                return "red";
        }
    }

    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case 'new':
                return Lang::get('new');
            case 'done':
                return Lang::get('done');
            case 'process':
                return Lang::get('doing');
            case 'cancel':
                return Lang::get('failed');
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

    public function getTypeTextAttribute()
    {
        if ($this->type == 'sell') {
            return Lang::get('sell');
        } else {
            return Lang::get('buy');
        }
    }

    public function getCreatedAtFaAttribute()
    {
        return Jalalian::forge($this->attributes['created_at'])->format('Y-m-d H:i:s');
    }
}
