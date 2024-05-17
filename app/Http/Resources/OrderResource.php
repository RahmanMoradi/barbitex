<?php

namespace App\Http\Resources;

use App\Helpers\Helper;
use App\Models\P2P\Offer;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

class OrderResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'item_id' => $this->id,
            'qty' => $this->apiV2 ? Helper::numberFormatPrecision($this->qty, $this->currency->decimal_size) : (string)$this->qty,
            'price' => $this->apiV2 ? Helper::numberFormatPrecision($this->price, 0) : number_format($this->price),
            'usd_price' => Helper::numberFormatPrecision($this->price / $this->usdt_price, 2),
            'wage' => number_format($this->price * ($this->type == 'sell' ? $this->currency->sell_percent : $this->currency->buy_percent) / 100),
            'status' => $this->status,
            'status_text' => $this->status_text,
            'status_color' => $this->status_color,
            'type' => $this->type,
            'type_text' => $this->type_text,
            'created_at' => $this->created_at,
            'created_at_fa' => $this->created_at_fa,
            'admin_body' => optional($this->more)->admin_body,
            'currency' => new CurrencyResurce($this->currency),
        ];
    }
}
