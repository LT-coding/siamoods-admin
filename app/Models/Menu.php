<?php

namespace App\Models;

use App\Enums\CustomizationPosition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static Builder|Menu headerMenu()
 * @method static Builder|Menu footerMenu()
 * @method static Builder|Menu active() */

class Menu extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeHeaderMenu(Builder $query): void
    {
        $query->where(['type'=>CustomizationPosition::header->name,'parent_id'=>null])->with('children')->orderBy('position');
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status',1);
    }

    public function scopeFooterMenu(Builder $query): void
    {
        $query->where(['type'=>CustomizationPosition::footer->name,'parent_id'=>null])->with('children')->orderBy('position');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Menu::class,'parent_id')->where('status',1)->orderBy('position');
    }

    public function childrenAll(): HasMany
    {
        return $this->hasMany(Menu::class,'parent_id')->orderBy('position');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class,'parent_id');
    }
}
