<?php

namespace App\Models;

use App\Traits\StatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PowerLabel extends Model
{
    use HasFactory, StatusTrait;

    protected $guarded = [];
}
