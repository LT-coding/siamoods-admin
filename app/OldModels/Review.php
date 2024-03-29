<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    use HasFactory;
    protected $fillable=[
            'product_id',
            'haysell_id',
            'name',
            'review',
            'rating',
            'ip',
            'status'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'haysell_id','haysell_id');
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status',1);
    }
}
