<?php

namespace App\Enums;

/**
 *
 */
enum MetaTypes
{
    use EnumTool;

    case static_page;
    case page;
    case blog;
    case category;
    case general_cat;
    case product;
}
