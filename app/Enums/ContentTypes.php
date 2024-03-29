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
}
