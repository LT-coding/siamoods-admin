<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingArea extends Model
{
    use HasFactory;

    protected $fillable=[
        'shipping_type_id',
        'area',
        'time'
    ];


    public function rates(): HasMany
    {
        return $this->hasMany(ShippingRate::class,'shipping_area_id','id');
    }

}
