<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class Order
{
    #[Assert\NotNull(message: "The 'product' field should not be empty")]
    private Product $product;
    #[Assert\NotNull(message: "The 'taxNumber' field should not be empty")]
    private string $taxNumber;
    private Coupon|null $couponCode;
    #[Assert\NotNull(message: "The 'paymentProcessor' field should not be empty")]
    private array|null $paymentProcessor;

    /**
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param Product|null $product
     */
    public function setProduct(?Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return string|null
     */
    public function getTaxNumber(): ?string
    {
        return $this->taxNumber;
    }

    /**
     * @param string|null $taxNumber
     */
    public function setTaxNumber(?string $taxNumber): void
    {
        $this->taxNumber = $taxNumber;
    }

    /**
     * @return Coupon|null
     */
    public function getCouponCode(): ?Coupon
    {
        return $this->couponCode;
    }

    /**
     * @param Coupon|null $couponCode
     */
    public function setCouponCode(?Coupon $couponCode): void
    {
        $this->couponCode = $couponCode;
    }

    /**
     * @return array|null
     */
    public function getPaymentProcessor(): ?array
    {
        return $this->paymentProcessor;
    }

    /**
     * @param array|null $paymentProcessor
     */
    public function setPaymentProcessor(?array $paymentProcessor): void
    {
        $this->paymentProcessor = $paymentProcessor;
    }


}
