<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralCategoriesTranslation extends Model
{
    use HasFactory;
    protected $table='general_cats_translations';
    protected $fillable=[
        'general_category_id',
        'local',
        'name',
        'value'
    ];
}
