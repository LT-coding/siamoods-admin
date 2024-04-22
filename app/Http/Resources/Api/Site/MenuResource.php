<?php

namespace App\Http\Resources\Api\Site;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name_hy,
            'href' => $this->url,
            'subItems' => self::collection($this->children)
        ];
    }
}
