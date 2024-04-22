<?php

namespace App\Http\Resources\Api\Order;

use App\Models\OptionValue;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'tax' => $this->tax > 0 ? Product::formatPrice($this->tax) . '% (Tax)' : null,
        ];
    }
}
