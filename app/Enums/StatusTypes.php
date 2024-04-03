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

    /**
     * @param int $s
     * @return string
     */
    public static function statusText(int $s): string
    {
        return $s == self::inactive->value ? '<span class="text-danger">Ապաակտիվ</span>' : '<span class="text-success">Ակտիվ</span>';
    }
}
