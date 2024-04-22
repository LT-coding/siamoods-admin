<?php

namespace App\Http\Resources\Api\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'variant' => $this->name,
            'images' => $this->product_images ?? ['link' => asset('/img/no-image.png')],
            'colors' => new OptionResource($this->resource->color),
            'attributes' => AttributeResource::collection($this->resource->variantAttributes),
            'options' => OptionResource::collection($this->resource->variantOptions),
            'sizes' => SizeShortResource::collection($this->resource->sizes()->hasPrices()->available()->orderBy('code')->get()),
            'allow_customization' => $this->images()
                ->pluck('allow_customization')
                ->max(),
        ];
    }
}
