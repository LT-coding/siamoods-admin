<?php

namespace App\Enums;

/**
 *
 */
enum BannerTypes: string
{
    use EnumTool;

    case graph = 'Գրաֆիկական պիտակ';//0
    case text = 'Տեքստային պիտակ';//1

    /**
     * @return array
     */
    public static function typeList(): array
    {
        return [
            0 => "Գրաֆիկական պիտակ",
            1 => "Տեքստային պիտակ",
        ];
    }
}
