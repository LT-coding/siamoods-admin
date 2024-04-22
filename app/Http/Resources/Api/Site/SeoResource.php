<?php

namespace App\Http\Resources\Api\Site;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'meta_title' => $this->resource ? $this->meta_title : null,
            'meta_description' => $this->resource ? $this->meta_description : null,
            'meta_keywords' => $this->resource ? $this->meta_keywords : null
        ];
    }
}
