<?php

namespace App\Models;

use App\Models\Admin\Admin;
use App\Models\Card\Card;
use App\Models\Currency\Currency;
use App\Models\Network\Network;
use App\Models\Wallet\WalletEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;
use Morilog\Jalali\Jalalian;

class Wallet extends Model
{
    use HasFactory, WalletEvent;

    protected $guarded = ['id'];
    protected $appends = ['type_fa', 'status_fa', 'created_at_fa', 'transaction_link', 'type_fa_text', 'status_fa_text', 'status_color'];
    protected $hidden = ['admin_id'];

    public function getTypeFaAttribute()
    {
        if ($this->type == 'increment') {
            return "<span class='badge badge-success'>" . Lang::get('increment') . "</span>";
        } else {
            return "<span class='badge badge-danger'>" . Lang::get('decrement') . "</span>";
        }
    }

    public function getStatusFaAttribute()
    {
        switch ($this->status) {
            case 'new':
                return "<span class='badge badge-info'>" . Lang::get('pending') . "</span>";
            case 'process':
                return "<span class='badge badge-primary'>".Lang::get('doing')."</span>";
            case 'done':
                return "<span class='badge badge-success'>".Lang::get('done')."</span>";
            case 'cancel':
                return "<span class='badge badge-danger'>".Lang::get('canceled')."</span>";
        }
    }


    public function getTypeFaTextAttribute()
    {
        if ($this->type == 'increment') {
            return Lang::get('increment');
        } else {
            return Lang::get('decrement');
        }
    }

    public function getStatusFaTextAttribute()
    {
        switch ($this->status) {
            case 'new':
                return Lang::get('pending');
            case 'process':
                return Lang::get('doing');
            case 'done':
                return Lang::get('done');
            case 'cancel':
                return Lang::get('canceled');
        }
    }

    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 'new':
                return "blue";
            case 'process':
                return "yellow";
            case 'done':
                return "green";
            case 'cancel':
                return "red";
        }
    }

    public function getCreatedAtFaAttribute()
    {
        return Jalalian::forge($this->created_at)->format('Y-m-d H:i:s');
    }

    public function getTransactionLinkAttribute()
    {
        return optional($this->currencyRelation)->explorer . '/' . $this->txid;
    }

    public function currencyRelation()
    {
        return $this->hasOne(Currency::class, 'symbol', 'currency');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function network()
    {
        return $this->belongsTo(Network::class);
    }
}
