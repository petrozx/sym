<?php

namespace App\Helpers\Validate;

use App\Helpers\Classes\TaxTaypes;

class TaxesValidate
{
    public function __construct(
        private readonly string $taxNumber,
    ){}

    private function generateTaxNumberPattern($template): string
    {
        $pattern = strtr($template, [
            'X' => '\d',
            'Y' => '[A-Z]',
        ]);

        return "/^{$pattern}$/";
    }

    public function validate(): bool|array
    {
        $countryCode = substr($this->taxNumber, 0, 2);
        $taxType = new TaxTaypes();
        try {
            $taxArray = $taxType->$countryCode;
            $pattern = $this->generateTaxNumberPattern($taxArray['mask']);
            if (preg_match($pattern, $this->taxNumber) === 1) {
                return $taxArray;
            }
        } catch (\Exception) {
            return false;
        }
        return false;
    }

}