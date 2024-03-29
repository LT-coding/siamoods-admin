<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GeneralCategory extends Model
{
    use HasFactory;

    protected $table='general_cats';

    protected $guarded = [];

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, 'general_category_id', 'id');
    }
}
