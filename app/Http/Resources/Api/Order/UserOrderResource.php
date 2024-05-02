<?php

namespace App\Http\Resources\Api\Order;

use App\Enums\Currencies;
use App\Enums\OrderStatuses;
use App\Http\Resources\Api\Profile\UserAddressItemResource;
use App\Models\Product;
use App\Models\UserAddress;
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
            'status' => $this->status ? OrderStatuses::getConstants()[$this->status] : null,
            'address' => $this->address_id ? new UserAddressItemResource(UserAddress::query()->find($this->address_id)) : json_decode($this->shipping, true),
            'payment_method' => $this->payment_method,
            'transaction_id' => $this->transaction_id,
            'subtotal' => Product::formatPrice($this->subtotal),
            'delivery' => Product::formatPrice($this->delivery),
            'tax' => Product::formatPrice($this->tax),
            'total' => Product::formatPrice($this->total),
            'currency' => $this->currency,
            'order_date' => Carbon::parse($this->paid_at)->format('d.m.Y'),
            'currency_text' => Currencies::listLower()[$this->currency]
        ];
    }
}
