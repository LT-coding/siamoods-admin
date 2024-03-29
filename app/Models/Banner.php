<?php

namespace App\Models;

use App\Enums\StatusTypes;
use App\Traits\ImageLinkTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory, ImageLinkTrait;

    protected $guarded = ['icon'];

    public function scopeActive(Builder $query): void
    {
        $query->where('status', StatusTypes::active->value);
    }
}
