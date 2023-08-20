<?php

namespace App\Entity;

enum CouponType: string
{
    case FIX = 'FIX';
    case CALCULATE = 'CALCULATE';
}
