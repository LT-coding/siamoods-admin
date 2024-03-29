<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsMeta extends Model
{
    use HasFactory;
    protected $fillable=[
        'detail_id',
        'meta_title',
        'meta_desc',
        'meta_key',
    ];
}
