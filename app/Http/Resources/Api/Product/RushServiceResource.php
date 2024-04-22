<?php

namespace App\Http\Resources\Api\Product;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RushServiceResource extends JsonResource
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
            'service_days' => Carbon::now()->addDays($this->service_days)->format('M d, Y'),
            'service_price' => Product::formatPrice($this->service_price),
        ];
    }
}
