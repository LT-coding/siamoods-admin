<?php

namespace App\Http\Resources\Api\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
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
            'user_id' => $this->user_id,
            'variant_code' => $this->variant_code,
            'sizes' => CartItemSizeResource::collection($this->resource->sizes),
            'color' => $this->color,
            'options' => $this->options,
            'shipping_method' => $this->shipping_method,
            'rush_service' => $this->rush_service,
            'related' => $this->related,
            'customized_images' => CustomizedImageResource::collection($this->resource->customizedImages),
        ];
    }
}
