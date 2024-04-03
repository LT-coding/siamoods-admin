<?php

namespace App\OldModels;

use App\Services\Tools\MediaService;
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
    const TABLE_NAME = 'products';

    protected $table = self::TABLE_NAME;

    use HasFactory;
    protected $fillable=[
        'articul',
        'item_name',
        'item_type',
        'type',
        'sort',
        'provider',
        'unique_id',
        'balance_control',
        'additional',
        'discount_end_date',
        'discount',
        'discount_type',
        'description',
        'item_type_num',
        'haysell_id',
        'liked',
        'delete',
    ];

    public function content(): Attribute
    {
        return Attribute::make(get: fn($value) => $this->productDetails()->where('detail_id','89')->first()?->value);
    }

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
//    public function categories(): HasMany
//    {
//        return $this->hasMany(ProductCategory::class,'product_id','id');
//    }

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

    public function meta(): HasOne
    {
        return $this->hasOne(ProductMeta::class,'product_id','id');
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class,'order_products','order_id','product_id');
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(Product::class,'product_id','id');
    }

    public function productDetails(): HasMany
    {
        return $this->hasMany(ProductDetail::class,'product_id','id');
    }

    public function getGeneralImageAttribute(){
        return $this->images->where('is_general',1)->first();
    }
//    public function getTypeAttribute()
//    {
//        return $this->with(['payment'])->first()->payment->name;
//    }

    public function getSlugAttribute() {
//        return $this->meta?->seo ?? $this->item_name;
//        $detail = $this->productDetails()->where('detail_id',118)->first();
        return $this->meta?->url;
    }

    public function getTitleAttribute(): string
    {
        return __('Օնլայն խանութ') . ' :: '. 'Ականջօղեր' .' :: ' . $this->item_name;
    }

    public function getComputedDiscountAttribute(): string
    {
        if ($this->discount_left) {
            return $this->discount;
        }
        return false;
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
