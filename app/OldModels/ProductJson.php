<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductJson extends Model
{
    use HasFactory;

    protected $fillable=[
        'product_id','json'
    ];
}
