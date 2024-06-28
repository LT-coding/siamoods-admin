<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'order_id', 'status', 'haysell_id', 'variation_haysell_id', 'quantity', 'price',
        'sale', 'discount_price', 'gift'];

    protected $casts = [
        'status' => OrderStatusEnum::class,
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'haysell_id','haysell_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCartProducts(Builder $query): void
    {
        $query->where('status', OrderStatusEnum::UNDEFINED)
            ->whereNull('order_id');
    }
}
