<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRecomendation extends Model
{
    use HasFactory;
    protected $fillable=[
        'product_id',
        'haysell_id',
        'recomendation_id'
    ];
}
