<?php

namespace App\Enums;

enum OrderTypeEnum: int
{
    use EnumTool;

    case TYPE_PRODUCT = 1;
    case TYPE_CARD = 2;
}
