<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    const DISCOUNT = 1;
    const FREE_DELIVERY = 0;
    const PRICE_REDUCTION = 2;

    protected $guarded = [];
}
