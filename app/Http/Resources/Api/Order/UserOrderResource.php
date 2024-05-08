<?php

namespace App\Http\Resources\Api\Order;

use App\Http\Resources\Api\Profile\AccountAddressResource;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserOrderResource extends JsonResource
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
            'code' => $this->code,
            'payment_method' => $this->payment_method,
            'transaction_id' => $this->transaction_id,
            'subtotal' => Product::formatPrice($this->subtotal),
            'delivery' => Product::formatPrice($this->delivery),
            'tax' => Product::formatPrice($this->tax),
            'total' => Product::formatPrice($this->total),
            'order_date' => Carbon::parse($this->paid_at)->format('d.m.Y'),
        ];
    }
}
