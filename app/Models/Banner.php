<?php

namespace App\Models;

use App\Enums\StatusTypes;
use App\Traits\ImageLinkTrait;
use App\Traits\StatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory, ImageLinkTrait, StatusTrait;

    protected $guarded = [];
}
