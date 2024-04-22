<?php

namespace App\Http\Resources\Api\Product;

use App\Enums\Currencies;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RelatedProductResource extends JsonResource
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
            'title' => $this->title,
            'image' => $this->image_link,
            'additional_price' => Product::formatPrice($this->additional_price)
        ];
    }
}
