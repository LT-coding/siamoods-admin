<?php

namespace App\Http\Resources\Api\Order;

use App\Enums\Currencies;
use App\Http\Resources\Api\Profile\AccountAddressItemResource;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserOrderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'address' => $this->address_id ? new AccountAddressItemResource(UserAddress::query()->find($this->address_id)) : array_merge(json_decode($this->personal, true), json_decode($this->shipping, true)),
            'items' => CartItemShortResource::collection($this->resource->items)
        ];
    }
}
