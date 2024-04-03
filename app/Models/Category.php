<?php

namespace App\Models;

use App\Enums\MetaTypes;
use App\Traits\ImageLinkTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use HasFactory, ImageLinkTrait;

    protected $fillable=[
        "id",
        'created_at',
        'updated_at',
        "general_category_id",
        "parent_id",
        "level",
        "name",
        "short_url",
        "image",
        "logo",
        "extra_categories",
        "recommended",
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
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function metas(): HasOne
    {
        return $this->hasOne(Meta::class, 'model_id', 'id')->where('type', MetaTypes::category->name);
    }
}
