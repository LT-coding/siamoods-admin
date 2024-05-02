<?php

namespace App\Models;

use App\Enums\ContentTypes;
use App\Enums\MetaTypes;
use App\Traits\ImageLinkTrait;
use App\Traits\MetaTrait;
use App\Traits\StatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Content extends Model
{
    use HasFactory, ImageLinkTrait, StatusTrait, MetaTrait;

    protected $guarded = [];

    public function scopePage(Builder $query): void
    {
        $query->where('type', ContentTypes::page->name);
    }

    public function scopeBlog(Builder $query): void
    {
        $query->where('type', ContentTypes::blog->name);
    }

    public function meta(): HasOne
    {
        return $this->hasOne(Meta::class, 'model_id', 'id')->where('type', MetaTypes::content->name);
    }

    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->type == ContentTypes::page->name ? config('app.frontend_url') .'/'. $this->meta_url : config('app.frontend_url') .'/'.$this->type.'/'. $this->meta_url
        );
    }
}
