<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsMetaTranslation extends Model
{
    use HasFactory;
    protected $fillable=[
        'detail_meta_id',
        'local',
        'name',
        'value'
    ];
}
