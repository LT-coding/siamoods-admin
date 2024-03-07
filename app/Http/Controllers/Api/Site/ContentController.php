<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Site\ContentResource;
use App\Models\Content;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ContentController extends Controller
{
    public function getContent(string $type, string $slug): ContentResource
    {
        $content = Content::query()->$type()->active()->where('slug',$slug)->firstOrFail();

        return new ContentResource($content);
    }

    public function getBlog(): AnonymousResourceCollection
    {
        $blog = Content::query()->blog()->active()->orderBy('created_at','desc')->get();

        return ContentResource::collection($blog);
    }
}
