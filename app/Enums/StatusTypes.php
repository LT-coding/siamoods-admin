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
            self::active->value => "Active",
            self::inactive->value => "Inactive",
        ];
    }

    /**
     * @param int $s
     * @return string
     */
    public static function statusText(int $s): string
    {
        return $s == self::inactive->value ? '<span class="text-danger">Inactive</span>' : '<span class="text-success">Active</span>';
    }
}
