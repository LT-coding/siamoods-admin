<?php

namespace App\Enums;

/**
 *
 */
enum MetaTypes
{
    use EnumTool;

    case static_page;
    case blog;
    case page;
    case category;
    case general_cat;
    case product;
}
