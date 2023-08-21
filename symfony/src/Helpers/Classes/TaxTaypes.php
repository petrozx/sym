<?php

namespace App\Helpers\Classes;

class TaxTaypes
{

    public array $DE = [
        'mask' => 'DEXXXXXXXXX',
        'percent' => 19,
    ];
    public array $IT = [
        'mask' => 'ITXXXXXXXXXXX',
        'percent' => 22,
    ];
    public array $GR = [
        'mask' => 'GRXXXXXXXXX',
        'percent' => 24,
    ];
    public array $FR = [
        'mask' => 'FRYYXXXXXXXXX',
        'percent' => 20,
    ];

}