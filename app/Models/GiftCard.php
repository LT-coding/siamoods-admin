<?php

namespace App\Models;

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
}
