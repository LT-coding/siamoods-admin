<?php

namespace App\Http\Resources\Api\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryMenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'all_products' => CategoryShortResource::collection($this->resource['all_products']),
            'menu_categories' => CategoryShortResource::collection($this->resource['menu_categories'])
        ];
    }
}
