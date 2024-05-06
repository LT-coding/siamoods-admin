<?php

namespace App\Traits;

use App\Enums\StatusTypes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait MetaTrait
{
    protected function meta_title(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->meta ? $this->meta->meta_title : ''
        );
    }

    protected function meta_url(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->meta ? $this->meta->url : ''
        );
    }

    protected function meta_description(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->meta ? $this->meta->meta_desc : ''
        );
    }

    protected function meta_keywords(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->meta ? $this->meta->meta_key : ''
        );
    }
}
