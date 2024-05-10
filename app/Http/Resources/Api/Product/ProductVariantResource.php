<?php

namespace App\Http\Resources\Api\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->variation->id,
            'title' => $this->resource->variation->title,
            'available' => $this->resource->balance,
            'price' => $this->resource->price?->price ?? $this->resource->product?->price?->price,
            'discount' => $this->product?->computed_discount,
            'discount_price' => $this->discount_price,
        ];
    }
}
