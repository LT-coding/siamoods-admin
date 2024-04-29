<?php

namespace App\Models;

use App\Traits\ImageLinkTrait;
use App\Traits\StatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingType extends Model
{
    use HasFactory, StatusTrait, ImageLinkTrait;

    protected $guarded = [];

    public function areas(): HasMany
    {
        return $this->hasMany(ShippingArea::class,'shipping_type_id','id');
    }
}
