<?php

namespace App\Http\Resources\Api\Site;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'image' => $this->image_link,
            'name' => $this->name,
            'url' => $this->url,
            'new_tab' => $this->new_tab,
        ];
    }
}
