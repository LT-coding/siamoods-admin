<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariationPrice extends Model
{
    use HasFactory;
    protected $fillable=[
        'prod_variation_id',
        'type',
        'price'
    ];
}
