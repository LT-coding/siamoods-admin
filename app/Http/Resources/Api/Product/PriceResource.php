<?php

namespace App\Http\Resources\Api\Product;

use App\Enums\Currencies;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PriceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'price' => Product::formatPrice($this->price),
            'price_from_count' => $this->price_from_count,
            'currency' => $this->size->variant->product->currency_sign
        ];
    }
}
