<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
            'role_id' => $this->role,
            'category' => optional($this->category)->title,
            'subject' => $this->subject,
            'message' => $this->message,
            'status' => $this->status,
            'status_fa' => $this->status_fa,
            'status_class' => $this->status_class,
            'status_color' => $this->status_color,
            'created_at' => $this->created_at_fa,
            'created_at_fa' => $this->created_at_fa,
            'updated_at' => $this->updated_at_fa,
            'answers' => TicketAnswerResource::collection($this->answers)
        ];
    }
}
