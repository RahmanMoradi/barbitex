<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
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
            'icon' => $this->bank_logo,
            'bank_name' => $this->bank_name_text,
            'card_number' => $this->card_number,
            'account_number' => $this->account_number,
            'sheba' => $this->sheba,
            'status' => $this->status_text,
            'status_color' => $this->status_color,
        ];
    }
}
