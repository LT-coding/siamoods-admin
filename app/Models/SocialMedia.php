<?php

namespace App\Models;

use App\Traits\ImageLinkTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory, ImageLinkTrait;

    protected $guarded = [];
}
