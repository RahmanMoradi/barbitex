<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\Jalalian;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'link' => route('home.blog.show', ['slug' => $this->slug]),
            'category' => $this->category->title,
            'title' => $this->title,
            'slug' => $this->slug,
            'image' => $this->image_url,
            'short_body' => strip_tags($this->short_body),
            'body' => $this->body,
            'created_at' => Jalalian::forge($this->created_at)->ago()
        ];
    }
}
