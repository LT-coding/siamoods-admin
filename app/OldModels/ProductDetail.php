<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;
    protected $fillable=[
        'product_id',
        'detail_id',
        'haysell_id',
        'value',
    ];
}
