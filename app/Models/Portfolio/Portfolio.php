<?php

namespace App\Models\Portfolio;

use App\Models\Order\Order;
use App\Models\Traid\Market\MarketOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function order()
    {
        if (isset($this->order_id)) {
            return $this->hasOne(Order::class, 'id', 'order_id');
        } else {
            return $this->hasOne(MarketOrder::class, 'id', 'market_order_id');
        }
    }
}
