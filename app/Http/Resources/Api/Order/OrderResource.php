<?php

namespace App\Http\Resources\Api\Order;

use App\Models\OptionValue;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'address_id' => $this->address_id,
            'personal' => $this->personal,
            'shipping' => $this->shipping,
            'payment_method' => $this->payment_method,
            'transaction_id' => $this->transaction_id,
            'subtotal' => Product::formatPrice($this->subtotal),
            'delivery' => Product::formatPrice($this->delivery),
            'total' => Product::formatPrice($this->total),
            'tax' => Product::formatPrice($this->tax),
            'currency' => $this->currency,
            'items' => CartItemShortResource::collection($this->resource->items)
        ];
    }
}
