<?php

namespace App\Enums;

/**
 *
 */
enum MetaTypes
{
    use EnumTool;

    case static_page;
    case content;
    case category;
    case general_cat;
    case product;
}
