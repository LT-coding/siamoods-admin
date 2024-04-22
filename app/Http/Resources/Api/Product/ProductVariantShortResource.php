<?php

namespace App\Http\Resources\Api\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantShortResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'size_code' => $this->sizes()->hasPrices()->available()->first()?->code,
            'variant_link' => $this->image,
            'variant_name' => $this->resource->name,
        ];
    }
}
