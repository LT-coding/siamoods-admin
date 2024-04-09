<?php

namespace App\Enums;

/**
 *
 */
enum LabelType: string
{
    use EnumTool;

    case graph = 'Գրաֆիկական պիտակ';//0
    case text = 'Տեքստային պիտակ';//1


    /**
     * @return array
     */
    public static function types(): array
    {
        return [
            self::graph,
            self::text
        ];
    }
}
