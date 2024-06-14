<?php

namespace App\Enums;

enum PositionType: string
{
    use EnumTool;

    case leftTop = 'Վերև-ձախ';//0
    case rightTop = 'Վերև-աջ';//1
    case leftMiddle = 'Կենտրոն-ձախ';//2
    case rightMiddle = 'Կենտրոն-աջ';//3
    case leftBottom = 'Ներքև-ձախ';//4
    case rightBottom = 'Ներքև-աջ';//5


    /**
     * @param bool $as_string
     * @return array|string
     */
    public static function positions(bool $as_string = false): array|string
    {
        $result= [
            self::leftTop,
            self::rightTop,
            self::leftMiddle,
            self::rightMiddle,
            self::leftBottom,
            self::rightBottom,
        ];

        return $as_string ? implode('|', $result) : $result;
    }
}
