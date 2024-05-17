<?php

namespace App\Http\Resources;

use App\Helpers\Helper;

class CurrencyResurce extends BaseResource
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
            'name' => $this->name,
            'image' => $this->iconUrl,
            'en_name' => $this->enname,
            'symbol' => $this->symbol,
            'wallet' => $this->wallet,
            'tag' => $this->tag,
            'qr' => $this->imageqr,
            'price' => $this->price,
            'receive_price' => $this->apiV2 ? Helper::numberFormatPrecision($this->receive_price) : number_format($this->receive_price),
            'irt_price' => $this->apiV2 ? Helper::numberFormatPrecision($this->irt_price) : number_format($this->irt_price),
            'send_price' => $this->apiV2 ? Helper::numberFormatPrecision($this->send_price) : number_format($this->send_price),
            'send_cost' => $this->send_cost,
            'decimal' => $this->decimal,
            'percent' => $this->percent,
            'percent_image' => $this->percent_image,
            'chart_image' => $this->chart_image,
            'color' => "0xsfffae11",
        ];
    }
}
