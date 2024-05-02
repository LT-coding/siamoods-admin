<?php

namespace App\Http\Resources\Api\Site;

use App\Enums\ContentTypes;
use App\Models\Content;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'image' => $this->image_link,
            'title' => $this->title,
            'slug' => $this->meta_url,
            'description' => $this->description,
            'meta_title' => $this->meta_title,
            'meta_keywords' => $this->meta_keywords,
            'meta_description' => $this->meta_description,
            'created_at' => Carbon::parse($this->created_at)->format('d F, Y'),
            'resents' => $this->type == ContentTypes::blog->name
                ? ResentBlogResource::collection(Content::query()->blog()->active()->where('id','!=',$this->id)->orderBy('created_at','desc')->limit(5)->get())
                : null
        ];
    }
}
