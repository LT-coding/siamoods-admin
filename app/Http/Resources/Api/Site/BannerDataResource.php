<?php

namespace App\Http\Resources\Api\Site;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'header_banners' => BannerResource::collection($this->resource['header_banners']),
            'home_banner' => new BannerResource($this->resource['home_banner']),
        ];
    }
}
