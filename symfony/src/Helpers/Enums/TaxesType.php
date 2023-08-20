<?php

namespace App\Helpers\Enums;

use App\Helpers\Trait\EnumHelper;

enum TaxesType: string
{
    case DE = 'DEXXXXXXXXX';
    case IT = 'ITXXXXXXXXXXX';
    case GR = 'GRXXXXXXXXX';
    case  FR = 'FRYYXXXXXXXXX';

    use EnumHelper;
}
