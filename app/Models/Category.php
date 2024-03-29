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

    protected $guarded = [];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_categories');
    }

    public function childCategories(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id', 'id');
    }

    public function metas(): HasOne
    {
        return $this->hasOne(Meta::class, 'model_id', 'id')->where('type', MetaTypes::category->name);
    }
}
