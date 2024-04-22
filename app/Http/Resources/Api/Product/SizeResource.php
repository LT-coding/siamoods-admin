<?php

namespace App\Http\Resources\Api\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SizeResource extends JsonResource
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
            'name' => $this->sizeName,
            'quantity' => $this->quantity,
            'price' => Product::formatPrice($this->price),
            'discount_price' => $this->discount_price,
            'prices' => PriceResource::collection($this->resource->prices)
        ];
    }
}
