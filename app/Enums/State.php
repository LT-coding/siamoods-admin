<?php

namespace App\Enums;

/**
 *
 */
enum State: string
{
    use EnumTool;

    case AG = 'Արագածոտն';
    case AR = 'Արարատ';
    case AV = 'Արմավիր';
    case NG = 'Արցախ';
    case GR = 'Գեղարքունիք';
    case ER = 'Երևան';
    case LO = 'Լոռի';
    case KT = 'Կոտայք';
    case SH = 'Շիրակ';
    case SU = 'Սյունիք';
    case VD = 'Վայոց ձոր';
    case TV = 'Տավուշ';
}
