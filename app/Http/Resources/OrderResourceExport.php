<?php

namespace App\Http\Resources;

use App\Models\P2P\Offer;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

class OrderResourceExport extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $CurrencyData = new CurrencyResurce($this->currency);
        return [
            'id' => $this->id,
            'user_id' => User::find($this->user_id)->name,
            'item_id' => $this->id,
            'wallet' => $this->wallet,
            'tag' => $this->tag,
            'qty' => $this->qty,
            'wage' => $this->wage,
            'price' => number_format($this->price),
            'price_usd' => 'قیمت تتر در زمان خرید:'.number_format($this->price_usd),
            'send_cost' => $this->send_cost,
            'time_send' => $this->time_send,
            'body' => $this->body,
            'status' => $this->status,
            'status_text' => $this->status_fa_text,
            'status_color' => $this->status_color,
            'type' => $this->type,
            'type_text' => $this->type_fa,
            'created_at' => $this->created_at,
            'created_at_fa' => $this->created_at_fa,
            'admin_body' => optional($this->more)->admin_body,
            'txid' => optional($this->more)->txid,
            'currency' => $CurrencyData->name,
        ];
    }
}
