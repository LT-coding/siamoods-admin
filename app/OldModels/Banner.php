<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'type',
        'media',
        'url',
        'status',
        'new_tab',
        'order'
    ];
}
