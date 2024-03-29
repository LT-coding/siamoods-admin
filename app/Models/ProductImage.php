<?php

namespace App\Models;

use App\Services\Tools\MediaService;
use App\Traits\ImageLinkTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory, ImageLinkTrait;

    protected $guarded = [];
}
