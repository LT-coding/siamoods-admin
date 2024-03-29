<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductMeta extends Model
{
    use HasFactory;

    protected $fillable=[
        'product_id',
        'haysell_id',
        'url',
        'meta_title',
        'meta_desc',
        'meta_key'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
