<?php

namespace App\Enums;

enum ShipAreaEnum: string
{
    use EnumTool;

    case yerevan = 'Երևան';//0
    case artsakh = 'Արցախ';//1
    case regions = 'Հայաստանի մարզեր';//2



    /**
     * @param bool $as_string
     * @return array|string
     */
    public static function areas(bool $as_string = false): array|string
    {
        $result= [
            self::yerevan,
            self::artsakh,
            self::regions
        ];

        return $as_string ? implode('|', $result) : $result;

    }


}
