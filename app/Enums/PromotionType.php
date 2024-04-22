<?php

namespace App\Enums;

enum PromotionType: string
{
    use EnumTool;

    case shipping = 'Անվճար առաքում';//0
    case discount = 'Զեղչ';//1
    case amount = 'Գնիջեցում';//2

    /**
     * @param bool $as_string
     * @return array|string
     */
    public static function promotions(bool $as_string = false): array|string
    {
        $result= [
            self::shipping,
            self::discount,
            self::amount
        ];

        return $as_string ? implode('|', $result) : $result;
    }
}
