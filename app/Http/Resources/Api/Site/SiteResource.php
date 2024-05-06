<?php

namespace App\Http\Resources\Api\Site;

use App\Http\Resources\Api\Product\ProductShortResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'customizations' => [
                'logo' => new CustomizationResource($this->resource['customizations']['logo']),
                'copyright' => new CustomizationResource($this->resource['customizations']['copyright']),
                'paymentDelivery' => CustomizationResource::collection($this->resource['customizations']['payment_delivery']),
                'headerData' => MenuResource::collection($this->resource['customizations']['header_menu']),
                'footerData' => MenuResource::collection($this->resource['customizations']['footer_menu']),
                'social' => SocialResource::collection($this->resource['customizations']['social']),
            ],
            'banners' => BannerResource::collection($this->resource['banners']),
            'discount' => ProductShortResource::collection($this->resource['discount']),
            'new' => ProductShortResource::collection($this->resource['new']),
            'liked' => ProductShortResource::collection($this->resource['liked']),
            'blog' => ContentShortResource::collection($this->resource['blog'])
        ];
    }
}
