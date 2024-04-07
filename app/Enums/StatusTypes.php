<?php

namespace App\Enums;

/**
 *
 */
enum StatusTypes: int
{
    use EnumTool;

    case active = 1;
    case inactive = 0;

    /**
     * @return array
     */
    public static function statusList(): array
    {
        return [
            self::active->value => "Ակտիվ",
            self::inactive->value => "Ապաակտիվ",
        ];
    }
}
