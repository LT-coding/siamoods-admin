<?php

namespace App\Models;

use App\Enums\MetaTypes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function balance(): HasOne
    {
        return $this->hasOne(ProductBalance::class,'product_id','id');
    }

    public function labels(): HasOneThrough
    {
        return $this->hasOneThrough(PowerLabel::class,ProductPowerLabel::class,'product_id','id');
    }

    public function gift(): HasOne
    {
        return $this->hasOne(ProductGift::class,'product_id','id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class,'haysell_id','haysell_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class,'product_id','id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(ProductPrice::class, 'product_id', 'id');
    }

    public function price():HasOne
    {
        return $this->hasOne(ProductPrice::class, 'product_id', 'id')->where('type','static');
    }

    public function cats():HasMany
    {
        return $this->hasMany(ProductCategory::class, 'product_id', 'id')->where('type','basic');
    }

    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class, 'product_id', 'id');
    }

    public function metas(): HasOne
    {
        return $this->hasOne(Meta::class, 'model_id', 'id')->where('type', MetaTypes::product->name);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class,'order_products','order_id','haysell_id');
    }

    public function productDetails(): HasMany
    {
        return $this->hasMany(ProductDetail::class,'product_id','id');
    }

    public function content(): Attribute
    {
        return Attribute::make(get: fn() => $this->productDetails()->where('detail_id','89')->first()?->value);
    }

    public function generalImage(): Attribute
    {
        return Attribute::make(get: fn() => $this->images()->where('is_general',1)->first());
    }

    public function slug(): Attribute
    {
        return Attribute::make(get: fn() => $this->meta?->url);
    }

    public function computedDiscount(): Attribute
    {
        return Attribute::make(get: fn() => $this->discount_left ? $this->discount : false);
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
}
