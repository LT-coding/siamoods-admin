<?php

namespace App\Http\Resources\Api\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->short_url,
            'subTypes' => self::collection($this->resource->childCategories),
            'meta_title' => $this->metaTitle,
            'meta_keywords' => $this->metaKeywords,
            'meta_description' => $this->metaDescription,
        ];
    }
}
