<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCard extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function senderUser(){
        return $this->hasOne(User::class,'id','sender_id');
    }

    public function recipientUser(){
        return $this->hasOne(User::class,'id','recipient_id');
    }

    public function order(){
        return $this->hasOne(Order::class,'id','order_id');
    }
}
