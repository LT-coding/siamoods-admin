<?php

namespace App\Http\Resources\Api\Profile;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getKey(),
            'name' => $this->name,
            'lastname' => $this->lastname,
            'phone' => $this->phone,
            'email' => $this->email,
            'subscribe' => $this->subscription?->active()->first() ? 1 : 0,
            'shipping' => $this->resource->addresses()->where('type','shipping')->first() ? new AccountAddressResource($this->resource->addresses()->where('type','shipping')->first()) : null,
            'payment' => $this->resource->addresses()->where('type','payment')->first() ? new AccountAddressResource($this->resource->addresses()->where('type','payment')->first()) : null,
        ];
    }
}
