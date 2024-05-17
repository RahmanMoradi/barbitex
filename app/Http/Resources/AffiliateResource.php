<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

class AffiliateResource extends JsonResource
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
            'code' => $this['code'],
            'referrals' => UserResource::collection($this['referrals']),
            'referralsCount' => $this['referralsCount'],
            'orders' => OrderAffResource::collection($this['orders']),
            'commissions' => number_format($this['commissions']),
            'commissionsAverage' => number_format($this['commissionsAverage']),
        ];
    }
}
