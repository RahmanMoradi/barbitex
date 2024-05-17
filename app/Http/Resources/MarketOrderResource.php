<?php

namespace App\Http\Resources;

use anlutro\LaravelSettings\Facade as Settings;
use App\Helpers\Helper;
use Illuminate\Http\Resources\Json\JsonResource;

class MarketOrderResource extends JsonResource
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
            'market' => optional($this->market)->symbol,
            'count' => $this->count,
            'price' => $this->price,
            'sumPrice' => $this->sumPrice,
            'type' => $this->type_fa_text,
            'wage' => $this->type == 'sell' ? Helper::numberFormatPrecision(($this->sumPrice * Settings::get('market_fee') / 100), optional(optional($this->market)->currencySeller)->decimal) . ' ' . optional(optional($this->market)->currencySeller)->symbol :
                Helper::numberFormatPrecision(($this->count * Settings::get('market_fee') / 100), optional(optional($this->market)->currencyBuyer)->decimal) . ' ' . optional(optional($this->market)->currencyBuyer)->symbol,
            'status' => $this->status_fa_text,
            'created_at' => $this->created_at_fa,
        ];
    }
}
