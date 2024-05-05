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
            'haysell_id' => $this->haysell_id,
            'images' => ProductImageResource::collection($this->resource->images()->orderBy('is_general','desc')->get()),
            'title' => $this->item_name,
            'url' => $this->url,
            'price' => $this->price?->price,
            'discount' => $this->computed_discount ?? $this->computed_discount,
            'discount_left' => $this->show_discount_left && $this->discount_left ? 'Մնաց ' . $this->discount_left : null,
            'label' => $this->resource->label ? new PowerLabelResource($this->resource->label->active()) : null
        ];
    }
}
