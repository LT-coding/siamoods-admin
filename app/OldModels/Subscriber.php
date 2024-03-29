<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    const ACTIVE = 1;
    const NON_ACTIVE = 0;

    protected $fillable=[
        'email',
        'status'
    ];
}
