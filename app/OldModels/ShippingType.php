<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingType extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'cash',
        'description',
        'status',
        'image'
    ];

    public function areas(): HasMany
    {
        return $this->hasMany(ShippingArea::class,'shipping_type_id','id');
    }
}
