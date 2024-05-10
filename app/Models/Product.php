<?php

namespace App\Models;

use App\Enums\MetaTypes;
use App\Traits\MetaTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Product extends Model
{
    use HasFactory, MetaTrait;

    protected $guarded = [];

    public function balance(): HasOne
    {
        return $this->hasOne(ProductBalance::class,'haysell_id','haysell_id');
    }

    public function label(): BelongsTo
    {
        return $this->belongsTo(ProductPowerLabel::class, 'haysell_id', 'haysell_id');
    }

    public function gift(): HasOne
    {
        return $this->hasOne(ProductGift::class,'haysell_id','haysell_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'haysell_id', 'category_id', 'haysell_id', 'id', 'id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class,'haysell_id','haysell_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class,'haysell_id','haysell_id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(ProductPrice::class, 'haysell_id','haysell_id');
    }

    public function price():HasOne
    {
        return $this->hasOne(ProductPrice::class, 'haysell_id','haysell_id')->where('type','static');
    }

    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class, 'haysell_id','haysell_id');
    }

    public function meta(): HasOne
    {
        return $this->hasOne(Meta::class, 'model_id', 'haysell_id')->where('type', MetaTypes::product->name);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class,'order_products','order_id','haysell_id');
    }

    public function productDetails(): HasMany
    {
        return $this->hasMany(ProductDetail::class,'haysell_id','haysell_id');
    }

    public function category():Attribute
    {
        return Attribute::make(get: fn() => $this->categories()->where('categories.general_category_id',126)->first());
    }

    public function content(): Attribute
    {
        return Attribute::make(get: fn() => $this->productDetails()->where('detail_id','89')->first()?->value);
    }

    public function specification(): Attribute
    {
        return Attribute::make(get: fn() => $this->productDetails()->where('detail_id','97')->first()?->value);
    }

    public function generalImage(): Attribute
    {
        return Attribute::make(get: fn() => $this->images()->where('is_general',1)->first());
    }

    public function url(): Attribute
    {
        return Attribute::make(
            get: fn () => config('app.frontend_url') .'/product/'. $this->metaUrl
        );
    }

    public function computedDiscount(): Attribute
    {
        return Attribute::make(get: fn() => $this->discount_left ? $this->discount : false);
    }

    public function discountPrice(): Attribute
    {
        return Attribute::make(get: fn() => $this->computed_discount ? $this->price->price*(1 - $this->computed_discount) : null);
    }

    public function getDiscountLeftAttribute(): string
    {
        if ($this->discount_end_date && Carbon::parse($this->discount_end_date)->diffInMinutes(Carbon::now()) > 0) {
            $diffInMins = Carbon::parse($this->discount_end_date)->diffInMinutes(Carbon::now());
            $diffInHours = ceil($diffInMins / 60);
            $diffInDays = ceil(($diffInMins / 60) / 24);
            if ($diffInMins < 60) {
                $left = $diffInMins." րոպե";
            } elseif ($diffInHours < 24) {
                $left = (int)$diffInHours." ժամ";
            } else {
                $left = (int)$diffInDays." օր";
            }
            return $left;
        }
        return false;
    }

    public function getShowDiscountLeftAttribute(): string
    {
        if ($this->discount_left) {
            $diffInMins = Carbon::parse($this->discount_end_date)->diffInMinutes(Carbon::now());
            $diffInDays = ceil(($diffInMins / 60) / 24);
            if ((int)$diffInDays<=7) {
                return true;
            }
        }
        return false;
    }

    public static function detailsList(){
        $details=Detail::whereIn('id',[86,87,89,96,97,125])->orderby('type')->get();
        $data=[];
        foreach ($details as $detail){
            if(str_contains($detail->name,'նկարագրություն')){
                $type='textarea';
            }else{
                $type='input';
            }
            $data[$detail->id]=[
                'type'=>$type,
                'name'=>$detail->name
            ];
        }

        return $data;
    }

    public static function formatPrice($price): string
    {
        return number_format($price);
    }
}
