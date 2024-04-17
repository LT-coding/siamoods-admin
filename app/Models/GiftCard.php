<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GiftCard extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function senderUser(): HasOne
    {
        return $this->hasOne(User::class,'id','sender_id');
    }

    public function recipientUser(): HasOne
    {
        return $this->hasOne(User::class,'id','recipient_id');
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class,'id','order_id');
    }

    public function spend():Attribute
    {
        return Attribute::make(get: fn() => Order::query()->where('gift_card_id',$this->id)->sum('promo_gift_count'));
    }

    public function exist():Attribute
    {
        return Attribute::make(get: fn() => $this->amount - $this->spend);
    }
}
