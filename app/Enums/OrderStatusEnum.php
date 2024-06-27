<?php

namespace App\Enums;

enum OrderStatusEnum: int
{
    use EnumTool;

    case UNDEFINED = 0;
    case REGISTERED = 1;
    case READY_TO_SEND = 2;
    case COMPLETED = 3;
    case CANCELED = 4;
    case NOT_COMPLETED = 5;

    public function name(): string
    {
        return match($this)
        {
            self::REGISTERED => 'Գրանցված',
            self::READY_TO_SEND => 'Պատրաստ է առաքման',
            self::COMPLETED => 'Առաքված/Կատարված',
            self::CANCELED => 'Չեղարկված',
            self::NOT_COMPLETED => 'Չհաջողված',
        };
    }

    public static function searchList(): array
    {
        return [
            1 => 'Գրանցված',
            2 => 'Պատրաստ է առաքման',
            3 => 'Առաքված/Կատարված',
            4 => 'Չեղարկված',
            5 => 'Չհաջողված',
        ];
    }
}
