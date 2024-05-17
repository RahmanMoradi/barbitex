<?php

namespace App\Http\Resources;

use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class MarketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $user = User::with('balances')->find(Auth::guard('api')->id());
        $balanceOne = $user->balances->where('currency', optional($this->currencyBuyer)->symbol)->first();
        $balanceTwo = $user->balances->where('currency', optional($this->currencySeller)->symbol)->first();
        $balances = collect([
            'buy' => floatval($user && $balanceOne ? $balanceOne->balance_free : 0),
            'sell' => floatval($user && $balanceTwo ? $balanceTwo->balance_free : 0)
        ]);

        return [
            'id' => $this->id,
            'icon' => optional($this->currencyBuyer)->icon_url,
            'symbol' => $this->symbol,
            'price' => Helper::numberFormatPrecision(optional($this->currencyBuyer)->price, optional($this->currencyBuyer)->decimal),
            'percent' => optional($this->currencyBuyer)->percent,
            'decimal' => optional($this->currencyBuyer)->decimal,
            'decimalSize' => optional($this->currencyBuyer)->decimal_size,
            'currencyOne' => optional($this->currencyBuyer)->symbol,
            'currencyTwo' => optional($this->currencySeller)->symbol,
            'BalanceOne' => Helper::numberFormatPrecision($balances['buy'], optional($this->currencyBuyer)->decimal),
            'BalanceTwo' => Helper::numberFormatPrecision($balances['sell'], optional($this->currencySeller)->decimal)
        ];
    }
}
