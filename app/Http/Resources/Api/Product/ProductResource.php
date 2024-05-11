<?php

namespace App\Http\Resources\Api\Product;

use App\Models\Product;
use App\Models\ProductRecommendation;
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
        $related = ProductRecommendation::query()->where('haysell_id', $this->haysell_id)->get()->pluck('recommendation_id')->toArray();

        return [
            'haysell_id' => $this->haysell_id,
            'images' => ProductImageResource::collection($this->resource->images()->orderBy('is_general', 'desc')->get()),
            'title' => $this->item_name,
            'url' => $this->url,
            'price' => $variant && $this->resource->variations->where('variation_id',$variant)->first()?->price ? $this->resource->variations->where('variation_id',$variant)->first()?->price->price : $this->price?->price,
            'discount' => $this->computed_discount,
            'discount_price' => $this->discount_price,
            'discount_left' => $this->show_discount_left && $this->discount_left ? 'Մնաց ' . $this->discount_left : null,
            'label' => $this->resource->label?->active() ? new PowerLabelResource($this->resource->label) : null,
            'is_favorite' => $user ? $user->favorites()->where('haysell_id', $this->haysell_id)->exists() : false,
            'available' => $variant && $this->resource->variations->where('variation_id',$variant)->first() ? $this->resource->variations->where('variation_id',$variant)->first()->balance
                : ($this->resource->variations->first() ? $this->resource->variations->first()?->balance : $this->resource->balance?->balance),
            'variation_type' => $this->resource->variations()?->first()?->variation?->variation_type?->title,
            'variations' => ProductVariantResource::collection($this->resource->variations()->get()),
            'specification' => $this->specification,
            'description' => $this->description,
            'weight' => $this->weight,
            'size' => $this->size,
            'meta_title' => $this->metaTitle,
            'meta_keywords' => $this->metaKeywords,
            'meta_description' => $this->metaDescription,
            'reviews' => ReviewResource::collection($this->resource->reviews()->active()->get()),
            'linked_title' => 'Ավելացրեք շղթա',
            'linked_products' => $this->resource->category->id == 27455 ? ProductShortResource::collection(Product::query()->whereHas('categories', function ($query){
                $query->where('category_id', 27458);
            })->available()->get()) : null,
            'related_products' => ProductShortResource::collection(Product::query()->whereIn('haysell_id', $related)->get())
        ];
    }
}
