<?php

namespace App\Traits;

use App\Enums\StatusTypes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait MetaTrait
{
    protected function metaTitle(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->meta ? $this->meta->meta_title : ''
        );
    }

    protected function metaUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->meta ? $this->meta->url : ''
        );
    }

    protected function metaDescription(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->meta ? $this->meta->meta_desc : ''
        );
    }

    protected function metaKeywords(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->meta ? $this->meta->meta_key : ''
        );
    }
}
