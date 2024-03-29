<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function areas(): HasMany
    {
        return $this->hasMany(ShippingArea::class,'shipping_type_id','id');
    }
}
