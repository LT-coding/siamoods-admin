<?php

namespace App\Http\Resources\Api\Site;

use App\Enums\ContentTypes;
use App\Models\Content;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResentBlogResource extends JsonResource
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
            'slug' => $this->metaUrl,
            'date' => Carbon::parse($this->created_at)->format('d.m.Y'),
        ];
    }
}
