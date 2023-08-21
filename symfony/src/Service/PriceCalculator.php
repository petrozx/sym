<?php

namespace App\Service;

use App\Entity\Order;
use App\Helpers\Decoder\OrderDecoder;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PriceCalculator
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly CouponRepository  $couponRepository,
    ){}

    public function calculatePrice(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $order = (new OrderDecoder(
            request: $request,
            couponRepository: $this->couponRepository,
            productRepository: $this->productRepository)
        )->tryDecode($validator);
        if ($order instanceof Order) {
                $resultPrice = $this->calculation($order);
                $result = new JsonResponse(['Price' => $resultPrice], 200);
        } else {
            $result = new JsonResponse($order, 400);
        }
        return $result;
    }

    public function calculation(Order $order): float|int
    {
        $sumTax = ($order->getProduct()->getPrice() * $order->getTaxNumber()['percent'])/100;
        $sum = $order->getProduct()->getPrice() + $sumTax;
        if (!empty($order->isCoupon())) {
            return match ($order->getCouponCode()->getType()->value) {
                'FIX' => $sum - $order->getCouponCode()->getDiscount(),
                'CALCULATE' => $sum - ($sum * $order->getCouponCode()->getDiscount())/100,
            };
        } else {
            return $sum;
        }
    }
}