<?php

namespace App\Http\Resources\Api\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProductShortResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $request->user('sanctum');

        return [
            'haysell_id' => $this->haysell_id,
            'images' => ProductImageResource::collection($this->resource->images()->orderBy('is_general', 'desc')->get()),
            'title' => $this->item_name,
            'slug' => $this->metaUrl,
            'price' => $this->price?->price,
            'discount' => $this->computed_discount ?? $this->computed_discount,
            'discount_left' => $this->show_discount_left && $this->discount_left ? 'Մնաց ' . $this->discount_left : null,
            'label' => $this->resource->label ? new PowerLabelResource($this->resource->label->active()) : null,
            'is_favorite' => $user ? $user->favorites()->where('haysell_id', $this->haysell_id)->exists() : false,
        ];
    }
}
