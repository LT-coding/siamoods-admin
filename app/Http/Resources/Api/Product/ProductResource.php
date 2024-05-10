<?php

namespace App\Http\Resources\Api\Product;

use App\Http\Resources\Api\Order\ShippingMethodResource;
use App\Models\Product;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        $user = $request->user('sanctum');
        $variant = $request->variant;

        return [
            'haysell_id' => $this->haysell_id,
            'images' => ProductImageResource::collection($this->resource->images()->orderBy('is_general', 'desc')->get()),
            'title' => $this->item_name,
            'url' => $this->url,
            'price' => $variant && $this->resource->variations->where('variation_id',$variant)->first()?->price ? $this->resource->variations->where('variation_id',$variant)->first()?->price->price : $this->price?->price,
            'discount' => $this->computed_discount ?? $this->computed_discount,
            'discount_left' => $this->show_discount_left && $this->discount_left ? 'Մնաց ' . $this->discount_left : null,
            'label' => $this->resource->label->active() ? new PowerLabelResource($this->resource->label) : null,
            'is_favorite' => $user ? $user->favorites()->where('haysell_id', $this->haysell_id)->exists() : false,
            'is_available' => $this->resource->balance?->balance > 0 || $variant && $this->resource->variations->where('variation_id',$variant)->first()?->balance > 0,
            'variation_type' => $this->resource->variations()?->first()?->variation?->variation_type?->title,
            'variations' => ProductVariantShortResource::collection($this->resource->variations()->get()),
            'specification' => $this->specification,
            'description' => $this->description,
            'meta_title' => $this->metaTitle,
            'meta_keywords' => $this->metaKeywords,
            'meta_description' => $this->metaDescription,
            'reviews' => ReviewResource::collection($this->resource->reviews()->get()),
        ];
    }
}
