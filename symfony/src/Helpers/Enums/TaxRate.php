<?php

namespace App\Helpers\Enums;

use App\Helpers\Trait\EnumHelper;

enum TaxRate: int
{
    case DE = 19;
    case IT = 22;
    case FR = 20;
    case GR = 24;

    use EnumHelper;
}
