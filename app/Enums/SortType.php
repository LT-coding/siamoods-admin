<?php

namespace App\Enums;

enum SortType:string
{
    use EnumTool;

    case haysell_id0desc = 'նորագույն իրերի';//0
    case item_name0desc = 'այբբենական կարգով. Ֆ-ից Ա';//1
    case item_name0asc = 'այբբենական կարգով. Ա-ից Ֆ';//2
    case price0desc = 'գնի ՝ նվազող';//4
    case price0asc = 'գնի՝ աճող';//3
    case discount0desc = 'զեղչի՝ բարձրից ցածր';//5
    case discount0asc = 'զեղչի՝ ցածրից բարձր';//6
    case liked = 'հայտնիության ՝ նվազող';//7



    /**
     * @param bool $as_string
     * @return array|string
     */
    public static function sorts(bool $as_string = false): array|string
    {
        $result= [
            self::haysell_id0desc,
            self::item_name0desc,
            self::item_name0asc,
            self::price0desc,
            self::price0asc,
            self::discount0desc,
            self::discount0asc,
            self::liked,
        ];

        return $as_string ? implode('|', $result) : $result;

    }


}
