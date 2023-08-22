<?php

namespace App\Service;


use App\Entity\Order;
use App\Helpers\Decoder\OrderDecoder;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PurchaseManager
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly CouponRepository  $couponRepository,
        private readonly PriceCalculator   $priceCalculator,
    ){}

    public function purchaseProduct(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $order = (new OrderDecoder(
            request: $request,
            couponRepository: $this->couponRepository,
            productRepository: $this->productRepository)
        )->tryDecode($validator);
        if ($order instanceof Order) {
            try {
                $resulSum = $this->priceCalculator->calculation($order);
                $paymentClass = $order->getPaymentProcessor()['class'];
                $paymentWay = new $paymentClass();
                $paymentMethod = $order->getPaymentProcessor()['action'];
                $resultOfPay = $paymentWay->$paymentMethod($resulSum);
                if ($resultOfPay !== false) {
                    $result = new JsonResponse('Thank you for the purchase', 200);
                } else {
                    $result = new JsonResponse('Payment dont pass', 400);
                }
            } catch (\Exception $e) {
                $result = new JsonResponse($e->getMessage(), 400);
            }
        } else {
            $result = new JsonResponse($order, 400);
        }
        return $result;
    }

}