<?php

namespace App\Http\Resources\Api\Site;

use App\Enums\ContentTypes;
use App\Http\Resources\Api\Product\ProductShortResource;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'blog' => ContentShortResource::collection($this->resource['blog']),
            'meta_title' => $this->resource['meta'] ? $this->resource['meta']->meta_title : null,
            'meta_keywords' => $this->resource['meta'] ? $this->resource['meta']->meta_key : null,
            'meta_description' => $this->resource['meta'] ? $this->resource['meta']->meta_desc : null,
            'resents' => ResentBlogResource::collection($this->resource['resents'])
        ];
    }
}
