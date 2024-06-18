<?php

namespace App\Enums;

enum ReviewStatus: string
{
    use EnumTool;

    case pending = 'Չդիտված';//0
    case confirmed = 'Հաստատված';//1
    case declined = 'Մերժված';//2

    /**
     * @param bool $as_string
     * @return array|string
     */
    public static function reviews(bool $as_string = false): array|string
    {
        $result [] = self::pending->value;
        $result [] = self::confirmed->value;
        $result [] = self::declined->value;

        return $as_string ? implode('|', $result) : $result;
    }

    public static function statusList(): array
    {
        return [
            0 => "Չդիտված",
            1 => "Հաստատված",
            2 => "Մերժված",
        ];
    }
}
