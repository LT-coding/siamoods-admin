<?php

namespace App\Models;

use App\Enums\MetaTypes;
use App\Traits\ImageLinkTrait;
use App\Traits\MetaTrait;
use App\Traits\StatusTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use HasFactory, ImageLinkTrait, StatusTrait, MetaTrait;

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
        return $this->belongsToMany(Product::class, 'product_categories', 'haysell_id');
    }

    public function childCategories(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function meta(): HasOne
    {
        return $this->hasOne(Meta::class, 'model_id', 'id')->where('type', MetaTypes::category->name);
    }

    public function url(): Attribute
    {
        return Attribute::make(
            get: fn () => config('app.frontend_url') .'/store/'. $this->short_url
        );
    }
}
