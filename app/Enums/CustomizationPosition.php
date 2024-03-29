<?php

namespace App\Enums;

enum CustomizationPosition: string
{
    use EnumTool;

    case header = 'Header';//0
    case footer = 'Footer';//1
    case main = 'Օժանդակ հատվածներ';//2



    /**
     * @param bool $as_string
     * @return array|string
     */
    public static function positions(bool $as_string = false): array|string
    {
        $result= [
            self::header,
            self::footer,
            self::main
        ];

        return $as_string ? implode('|', $result) : $result;

    }


}

