<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralCategoriesMeta extends Model
{
    use HasFactory;
    protected $table='general_cats_metas';
    protected $fillable=[
        'general_category_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];
}
