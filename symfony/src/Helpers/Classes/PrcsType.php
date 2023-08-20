<?php

namespace App\Helpers\Classes;

use App\PaymentProcessor\PaypalPaymentProcessor;
use App\PaymentProcessor\StripePaymentProcessor;

class PrcsType
{
    public array $paypal = [
        'class' => PaypalPaymentProcessor::class,
        'action' => 'pay'
    ];

    public array $stripe = [
        'class' => StripePaymentProcessor::class,
        'action' => 'processPayment'
    ];
}