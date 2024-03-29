<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariation extends Model
{
    use HasFactory;

    protected $fillable=[
        'variation_id',
        'variation_haysell_id',
        'product_id',
        'haysell_id',
        'balance',
        'image',
        'status'
    ];

    public function variation(): BelongsTo
    {
        return $this->belongsTo(Variation::class, 'variation_id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(ProductVariationPrice::class, 'prod_variation_id', 'id');
    }
}
