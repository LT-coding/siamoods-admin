<?php

namespace App\Http\Resources\Api\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductShortResource extends JsonResource
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
            'image' => $this->image ?? asset('/img/no-image.png'),
            'title' => $this->title,
            'slug' => $this->slug,
            'url' => $this->url,
            'external_url' => $this->external_url,
            'price' => Product::formatPrice($this->display_price),
            'currency' => $this->currency_sign,
            'discount' => $this->discount_percent,
            'discount_price' => $this->discount_price,
            'colors' => OptionValueResource::collection(
                $this->resource->variants()->hasPrices()->available()->with('color.values')->get()
                    ->filter(function ($variant) {
                        return $variant->color && $variant->color->values->isNotEmpty();
                    })
                    ->pluck('color.values')
                    ->flatten()
                    ->unique('value')
            ),
            'rate_count' => $this->rate_count,
            'rating' => $this->rating
        ];
    }
}
