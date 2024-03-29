<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductGift extends Model
{
    use HasFactory;
    protected $fillable=[
        'product_id',
        'gift_product_id'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'gift_product_id','id');
    }
}
