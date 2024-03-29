<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    const ORDER_CREATE = 1;//Պատվերի գրանցում/հաստատում
    const READY_FOR_DELIVERY = 2;//Պատրաստ է առաքման
    const DELIVERED = 3;//Պատվերն առաքված է
    const RATE = 4;//Գնահատել
    const CANCELED = 5;//Չեղարկված պատվեր
    const NOT_COMPLETED_ORDER = 6;//Չհաջողված պատվեր
    const ACCOUNT_VERIFY = 7;//Էլ փոստի հաստատում
    const REGISTER = 8;//Գրանցման ավարտ
    const PASSWORD_RESET = 9;//Գաղտնաբառի վերականգնում
    const WAITING_ORDER_2 = 10;//Լքված քարտ 2
    const WAITING_ORDER_7 = 11;//Լքված քարտ 7
    const WAITING_LIST_REGISTER = 12;//Waiting list register
    const WAITING_LIST_EXISTED = 13;//Waiting list when product is existed
    const CUSTOM = 14;//Waiting list when product is existed
    const GIFT = 15;//Waiting list when product is existed
    const LOW_INVENTORY = 16;//Waiting list when product is existed
    const RATE_NOTIFICATION = 17;//Waiting list when product is existed
    const NEW_ORDER = 18;//Waiting list when product is existed

    const TYPES = [
        self::ORDER_CREATE => 'Պատվերի գրանցում/հաստատում',
        self::READY_FOR_DELIVERY => 'Պատրաստ է առաքման',
        self::DELIVERED => 'Պատվերն առաքված է',
        self::RATE => 'Գնահատել',
        self::CANCELED => 'Չեղարկված պատվեր',
        self::NOT_COMPLETED_ORDER => 'Չհաջողված պատվեր',
        self::ACCOUNT_VERIFY => 'Էլ փոստի հաստատում',
        self::REGISTER => 'Գրանցման ավարտ',
        self::PASSWORD_RESET => 'Գաղտնաբառի վերականգնում',
        self::WAITING_ORDER_2 => 'Լքված քարտ 2',
        self::WAITING_ORDER_7 => 'Լքված քարտ 7',
        self::WAITING_LIST_REGISTER => 'Waiting list register',
        self::WAITING_LIST_EXISTED => 'Waiting list when product exists',
        self::CUSTOM => 'Custom',
        self::GIFT => 'GIFT',
        self::LOW_INVENTORY => 'LOW_INVENTORY',
        self::RATE_NOTIFICATION => 'RATE_NOTIFICATION',
        self::NEW_ORDER => 'NEW_ORDER',
    ];

    protected $guarded = [];
}
