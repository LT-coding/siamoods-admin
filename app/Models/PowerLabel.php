<?php

namespace App\Models;

use App\Traits\ImageLinkTrait;
use App\Traits\StatusTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PowerLabel extends Model
{
    use HasFactory, ImageLinkTrait, StatusTrait;

    protected $guarded = ['image'];

    protected function mediaJson(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->type != 0 ? json_decode($this->media) : null
        );
    }
}
