<?php

namespace App\OldModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GeneralCategory extends Model
{
    use HasFactory;
    protected $table='general_cats';
    protected $fillable=[
        'id',
        'title',
        'show_in_item',
        'show_in_web',
        'is_main',
        'is_price'
    ];


    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, 'general_category_id', 'id');
    }
}
