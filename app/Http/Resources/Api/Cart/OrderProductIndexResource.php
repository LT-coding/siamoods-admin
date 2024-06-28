<?php

namespace App\Http\Resources\Api\Cart;

use App\Http\Resources\Api\Product\ProductShortResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductIndexResource extends JsonResource
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
            'quantity' => $this->quantity,
            'product' => new ProductShortResource($this->product)
        ];
    }
}
