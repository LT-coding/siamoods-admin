<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    const TABLE_NAME = 'orders';

    protected $table = self::TABLE_NAME;

    const TYPE_PRODUCT = 1;
    const TYPE_CARD = 2;

    const UNDEFINED = 0;
    const REGISTERED = 1;
    const READY_TO_SEND = 2;
    const COMPLETED = 3;
    const CANCELED = 4;
    const NOT_COMPLETED = 5;

    const STATUS_MENU = [
        'Գրանցված'=>'1',
        'Պատրաստ է առաքման'=>'2',
        'Առաքված/Կատարված'=>'3',
        'Չեղարկված'=>'4',
        'Չհաջողված'=>'5',
    ];

    const STATUS_SHOW = [
        1=>'Գրանցված',
        2=>'Պատրաստ է առաքման',
        3=>'Առաքված/Կատարված',
        4=>'Չեղարկված',
        5=>'Չհաջողված',
    ];

    const NOT_APPROVED = 0; //չհաստատված
    const APPROVED = 1; //հաստատված

    protected $guarded = [];

    public static function nextSubmittedId()
    {
        return self::query()->first() ? self::query()->max('submitted_id') + 1 : 1;
    }

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function user(): HasOne
    {
//        return $this->hasOne(User::class,'haysell_id','user_haysell_id');
        return $this->hasOne(User::class,'id','user_id');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payments::class,'id','payment_id');
    }
}
