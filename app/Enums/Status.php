<?php

namespace App\Enums;

/**
 *
 */
enum Status: string
{
    use EnumTool;

    case inActive = 'Ապաակտիվ';//
    case active = 'Ակտիվ';//


    /**
     * @return array
     */
    public static function statusNames(): array
    {
        return [
            self::inActive,
            self::active
        ];
    }

}
