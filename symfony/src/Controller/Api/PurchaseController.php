<?php

namespace App\Controller\Api;


use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Service\PurchaseManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PurchaseController extends AbstractController
{
    #[Route(path: "/api/purchase", methods: ["POST"])]
    public function purchase(Request $request, PurchaseManager $purchaseManager, ValidatorInterface $validator): JsonResponse
    {
        return $purchaseManager->purchaseProduct($request, $validator);
    }
}