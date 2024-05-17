<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

class OrderAffResource extends JsonResource
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
            'user' => $this['user'],
            'price' => $this['price'],
            'created_at_fa' => $this['created_at_fa'],
        ];
    }
}
