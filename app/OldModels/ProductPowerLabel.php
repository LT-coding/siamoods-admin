<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPowerLabel extends Model
{
    use HasFactory;
    protected $fillable=[
        'product_id',
        'label_id'
    ];
}
