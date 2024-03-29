<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRecommendation extends Model
{
    use HasFactory;
    protected $fillable=[
        'product_id',
        'haysell_id',
        'recomendation_id'
    ];
}
