<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    const DISCOUNT = 1;
    const FREE_DELIVERY = 0;
    const PRICE_REDUCTION = 2;

    protected $fillable=[
                'name',
                'promo_code',
                'description',
                'period',
                'from',
                'to',
                'type',
                'value',
                'status'
    ];
}
