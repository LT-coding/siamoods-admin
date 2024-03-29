<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customization extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'value',
        'position',
        'type',
        'local',
    ];
}
