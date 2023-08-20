<?php

namespace App\Helpers\Validate;

use App\Helpers\Enums\TaxesType;

readonly class TaxesValidate
{
    public function __construct(
        private string $taxNumber,
    ){}

    private function generateTaxNumberPattern($template): string
    {
        $pattern = strtr($template, [
            'X' => '\d',
            'Y' => '[A-Z]',
        ]);

        return "/^{$pattern}$/";
    }

    public function validate(): bool
    {
        $countryCode = substr($this->taxNumber, 0, 2);
        $taxesType = TaxesType::tryFromName($countryCode);
        if (isset($taxesType)) {
            $pattern = $this->generateTaxNumberPattern($taxesType->value);
            return preg_match($pattern, $this->taxNumber) === 1;
        }
        return false;
    }

}