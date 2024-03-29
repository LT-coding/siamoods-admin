<?php

namespace App\Enums;

/**
 *
 */
enum StaticPages: string
{
    use EnumTool;

    case home = 'Գլխավոր';
    case shop = 'Օնլայն խանութ';
    case gift_card = 'Նվեր քարտ';
    case digital_gift_card = 'Օնլայն նվեր քարտ';
    case blog = 'Բլոգ';
}
