<?php

namespace App\Models;

use App\Enums\ContentTypes;
use App\Enums\MetaTypes;
use App\Enums\StatusTypes;
use App\Traits\ImageLinkTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Content extends Model
{
    use HasFactory, ImageLinkTrait;

    protected $guarded = [];

    public function scopePage(Builder $query): void
    {
        $query->where('type', ContentTypes::page->name);
    }

    public function scopeBlog(Builder $query): void
    {
        $query->where('type', ContentTypes::blog->name);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', StatusTypes::active->value);
    }

    public function metas(): HasOne
    {
        return $this->hasOne(Meta::class, 'model_id', 'id')->where('type', MetaTypes::content->name);
    }

    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->type == ContentTypes::page->name ? config('app.frontend_url') .'/'. $this->slug : config('app.frontend_url') .'/'.$this->type.'/'. $this->slug
        );
    }

    protected function metaTitle(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->metas ? $this->metas->meta_title : ''
        );
    }

    protected function metaDescription(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->metas ? $this->metas->meta_description : ''
        );
    }

    protected function metaKeywords(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->metas ? $this->metas->meta_keywords : ''
        );
    }
}
