<?php

namespace App\Enums;

/**
 *
 */
enum ContentTypes: string
{
    use EnumTool;

    case page = "Էջեր";
    case blog = "Բլոգ";

    static function getText(): array
    {
        return [
            self::page->name => "Էջ",
            self::blog->name => "Բլոգ",
        ];
    }
}
