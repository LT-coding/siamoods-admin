<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriesMetaTranslation extends Model
{
    use HasFactory;
    protected $fillable=[
        'category_meta_id',
        'local',
        'name',
        'value'
    ];
}
