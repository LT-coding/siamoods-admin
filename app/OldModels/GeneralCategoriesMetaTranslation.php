<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralCategoriesMetaTranslation extends Model
{
    use HasFactory;

    protected $table='general_cats_meta_translations';
    protected $fillable=[
        'general_category_meta_id',
        'local',
        'name',
        'value'
    ];
}
