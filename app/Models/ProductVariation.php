<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductVariation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function variation(): BelongsTo
    {
        return $this->belongsTo(Variation::class, 'variation_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'haysell_id', 'haysell_id');
    }

    public function price(): HasOne
    {
        return $this->hasOne(ProductVariationPrice::class, 'variation_haysell_id', 'variation_haysell_id');
    }

    public function discountPrice(): Attribute
    {
        return Attribute::make(get: fn() => $this->product->computed_discount ? $this->price*(1 - $this->product->computed_discount) : null);
    }
}
