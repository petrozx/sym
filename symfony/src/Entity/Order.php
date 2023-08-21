<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class Order
{
    #[Assert\NotNull(message: "Sorry, this product is missing")]
    private Product|null $product;
    #[Assert\NotNull(message: "Sorry, the code does not exist")]
    private array|null $taxNumber;
    private Coupon|null $couponCode;
    #[Assert\NotNull(message: "Sorry, the payment service is not supported")]
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
     * @return array|null
     */
    public function getTaxNumber(): ?array
    {
        return $this->taxNumber;
    }

    /**
     * @param array|null $taxNumber
     */
    public function setTaxNumber(?array $taxNumber): void
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



    public function isCoupon(): bool
    {
        return isset($this->couponCode);
    }

}
