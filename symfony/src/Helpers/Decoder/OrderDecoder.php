<?php

namespace App\Helpers\Decoder;

use App\Entity\Coupon;
use App\Entity\Product;
use App\Entity\Order;
use App\Helpers\Classes\ProcessorTypes;
use App\Helpers\Validate\TaxesValidate;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrderDecoder
{
    private string $requestData;
    private CouponRepository $couponRepository;
    private ProductRepository $productRepository;
    private array $errors = [];

    public function __construct(
        Request $request,
        CouponRepository $couponRepository,
        ProductRepository $productRepository,
    )
    {
        $this->requestData = $request->getContent();
        $this->couponRepository = $couponRepository;
        $this->productRepository = $productRepository;
    }

    public function tryDecode(ValidatorInterface $validator): Order|array
    {
        $jsonData = json_decode($this->requestData, true);
        if ($jsonData === null && json_last_error() !== JSON_ERROR_NONE) {
            $this->errors[] = 'The data format is incorrect';
        } else {
            $order = new Order();
            foreach ($jsonData as $key => $value) {
                $setterField = 'set'.$key;
                if (method_exists(Order::class, $setterField)) {
                    $order->$setterField(match ($key) {
                        'product' => $this->productCheck($value),
                        'taxNumber' => $this->taxCheck($value),
                        'couponCode' => $this->couponCheck($value),
                        'paymentProcessor' => $this->paymentProcessorCheck($value),
                    });
                } else {
                    $this->errors[] = 'The parameter, "' . $key . '", with the value, "' . $value . '", does not exist';
                }
            }
            $errors = $validator->validate($order);
            if (count($errors) > 0) {
                $re = '/(?\'message\'.*?) \(code/m';
                preg_match_all($re, (string) $errors, $matches, PREG_SET_ORDER, 0);
                $this->errors = array_merge($this->errors, array_reduce($matches, function ($acc, $el) {
                    $acc[] = trim($el['message']);
                    return $acc;
                },[]));
            }
        }
        if (!empty($this->errors)) {
            return $this->errors;
        }
        return $order;
    }

    private function paymentProcessorCheck($value): ?array
    {
        $prcs = new ProcessorTypes();
        if (isset($prcs->$value)) {
            return $prcs->$value;
        }
        return null;
    }

    private function productCheck($value): ?Product
    {
        $product = $this->productRepository->findOneBy(['id' => $value]);
        if (!empty($product)) {
            return $product;
        }
        return null;
    }

    private function couponCheck($value): ?Coupon
    {
        $coupon = $this->couponRepository->findOneBy(['code' => $value, 'used' => false]);
        if (!empty($coupon)) {
            return $coupon;
        }
        $this->errors[] = 'Sorry, your coupon is not valid';
        return null;
    }

    private function taxCheck(string $value): ?array
    {
        $taxResult = (new TaxesValidate($value))->validate();
        if ($taxResult) {
            return $taxResult;
        }
        return null;
    }
}