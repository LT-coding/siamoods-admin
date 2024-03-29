<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{

    const TABLE_NAME = 'categories';

    protected $table = self::TABLE_NAME;
    use HasFactory;
    protected $fillable=[
        "id",
        "general_category_id",
        "parent_id",
        "level",
        "name",
        "short_url",
        "image",
        "logo",
        "extra_categories",
        "recomended",
        "sort",
        "status",
        "is_top",
        "additional",
        "delete",
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_categories');
    }

    public function childCategories(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id', 'id');
    }

    public function meta(): HasOne
    {
        return $this->hasOne(CategoryMeta::class,'category_id','id');
    }
}
