<?php

namespace App\Http\Controllers\Api\Site;

use App\Enums\MetaTypes;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Site\BlogResource;
use App\Http\Resources\Api\Site\ContentResource;
use App\Models\Content;
use App\Models\Meta;

class ContentController extends Controller
{
    public function getContent(string $type, string $slug): ContentResource
    {
        $content = Content::query()->$type()->active()->where('slug',$slug)->firstOrFail();

        return new ContentResource($content);
    }

    public function getBlog(): BlogResource
    {
        $data = [
            'blog' => Content::query()->blog()->active()->orderBy('created_at','desc')->get(),
            'resents' => Content::query()->blog()->active()->where('id','!=',$this->id)->orderBy('created_at','desc')->limit(5)->get(),
            'meta' => Meta::query()->where(['type' => MetaTypes::static_page->name,'page' => 'blog'])->first()
        ];

        return new BlogResource($data);
    }
}
