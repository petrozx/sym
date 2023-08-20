<?php

namespace App\Controller\Api;

use App\Service\PriceCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class CalculatePriceController extends AbstractController
{

    #[Route(path: "/api/calculate-price", methods: ["POST"])]
    public function calculatePrice(Request $request, PriceCalculator $priceCalculator, ValidatorInterface $validator): JsonResponse
    {
        return $priceCalculator->calculatePrice($request, $validator);
    }
}