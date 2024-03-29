<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTranslation extends Model
{
    use HasFactory;
    protected $fillable=[
        'detail_id',
        'local',
        'name',
        'value'
    ];
}
