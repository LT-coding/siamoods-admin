<?php

namespace App\Http\Resources\Api\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryShortResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->code,
            'url' => $this->url,
            'external_url' => $this->external_url,
            'childCategories' => self::collection($this->childCategories),
            'products_count' => $this->resource->products()->hasPrices()->available()->count(),
        ];
    }
}
