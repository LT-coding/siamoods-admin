<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriesTranslation extends Model
{
    use HasFactory;
    protected $fillable=[
        'category_id',
        'local',
        'name',
        'value'
    ];
}
