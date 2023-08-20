<?php

namespace App\Helpers\Enums;

use App\Helpers\Trait\EnumHelper;

enum ProcessorType: string
{
    case paypal = 'App\PaymentProcessor\PaypalPaymentProcessor';
    case stripe = 'App\PaymentProcessor\StripePaymentProcessor';

    use EnumHelper;
}
