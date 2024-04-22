<?php

namespace App\Http\Resources\Api\Order;

use App\Enums\OrderItemsStatuses;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemShortResource extends JsonResource
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
            'product_code' => $this->variant->product->slug,
            'image' => $this->variant->image,
            'title' => $this->variant->title,
            'sizes' => CartItemSizeResource::collection($this->resource->sizes),
            'shipping' => Product::formatPrice($this->shipping_price),
            'rush_service' => $this->rush_service ? Product::formatPrice($this->rushService?->service_price) : null,
            'total' => Product::formatPrice($this->total),
            'currency' => $this->variant->product->currency_sign,
            'color' => $this->color ? $this->colorOption?->value : null,
            'status' => OrderItemsStatuses::getConstants()[$this->status] ?? null,
            'customized_images' => CustomizedImageResource::collection($this->resource->customizedImages),
        ];
    }
}
