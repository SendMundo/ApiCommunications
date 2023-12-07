<?php

namespace App\Controller;

use App\DTO\Input\RechargeInput;
use App\DTO\Input\SaleInfoInput;
use App\DTO\Input\SalePackageInput;
use App\Service\SaleService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/sale')]
class SaleController extends AbstractController
{
    private SaleService $saleService;

    /**
     * @param SaleService $saleService
     */
    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    /**
     * @param RechargeInput $rechargeInput
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/recharge', name: 'app_sale', methods: 'POST')]
    public function index(RechargeInput $rechargeInput): JsonResponse
    {
        $response = $this->saleService->sale($rechargeInput);
        return $this->json($response);
    }

    /**
     * @param SalePackageInput $input
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/package', name: 'app_sale_package', methods: 'POST')]
    public function sale(SalePackageInput $input): JsonResponse {
        $response = $this->saleService->salePackage($input);
        return $this->json($response);
    }

    #[Route('/sale-info', name: 'app_sale_info', methods: 'POST')]
    public function infoOfSale(SaleInfoInput $input): JsonResponse
    {
        $response = $this->saleService->getInfoOfSale($input);
        return $this->json($response);
    }
}
