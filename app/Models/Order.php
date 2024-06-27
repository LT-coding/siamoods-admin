<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use App\Enums\OrderTypeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class  Order extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => OrderStatusEnum::class,
        'type' => OrderTypeEnum::class,
    ];

    protected $guarded = [];

    public function items(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class,'id','payment_id');
    }

    public function shipping(): HasOne
    {
        return $this->hasOne(ShippingType::class,'id','shipping_type_id');
    }

    public function giftCard(): HasOne
    {
        return $this->hasOne(GiftCard::class,'order_id','id');
    }
}
