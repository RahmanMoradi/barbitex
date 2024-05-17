<?php

namespace App\Http\Resources;

use anlutro\LaravelSettings\Facade as Setting;
use App\Helpers\Helper;
use App\Models\Balance\Balance;
use App\Models\Traid\Market\Market;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $currencyId = $this->id;
        $user_id = \Auth::guard('api')->id();
        $array = parent::toArray($request);
        return
            [
                'id' => $this->id,
                'name' => $this->name,
                'icon' => $this->icon,
                'symbol' => $this->symbol,
                'explorer' => $this->explorer,
                'price' => Helper::numberFormatPrecision($this->price, $this->decimal),
                'count' => $this->count,
                'decimal' => $this->decimal,
                'decimal_size' => $this->decimal_size,
                'percent' => $this->percent,
                'position' => $this->position,
                'type' => $this->type,
                'market' => $this->market,
                'active' => $this->active,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'iconUrl' => $this->iconUrl,
                'irt_price' => $this->irt_price,
                'send_price' => $this->send_price,
                'receive_price' => $this->receive_price,
                'percent_image' => $this->percent_image,
                'chart_image' => $this->chart_image,
                'color' => "0xff" . str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT),
                'sell_percent' => $this->sell_percent,
                'buy_percent' => $this->buy_percent,
                'networks' => $this->networks,
            ] +
            [
                'count_user' => [
                    'IRT' => floatval(Balance::where('currency', $array['symbol'])->where('user_id', $user_id)->first() ? (string)(Balance::where('currency', $array['symbol'])->where('user_id', $user_id)->first()->balance_free * Setting::get('dollar_pay')) : '0'),
                    'USD' => floatval(Balance::where('currency', $array['symbol'])->where('user_id', $user_id)->first() ? (string)(Balance::where('currency', $array['symbol'])->where('user_id', $user_id)->first()->balance_free) : '0'),
                ]
            ] +
            [
                'markets' => MarketResource::collection(Market::where('currency_buy', $currencyId)->where('status', 1)->get())
            ] +
            [
                'chartData' => $this->chart_data ? json_decode($this->chart_data) : []
            ];
    }

    private function randomPrice($price)
    {

    }
}
