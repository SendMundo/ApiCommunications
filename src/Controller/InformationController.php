<?php

namespace App\Controller;

use App\DTO\Input\InformationInput;
use App\Service\InformationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/information')]
class InformationController extends AbstractController
{
    private InformationService $info;

    /**
     * @param InformationService $info
     */
    public function __construct(InformationService $info)
    {
        $this->info = $info;
    }

    #[Route('/packages', name: 'app_information_packages', methods: ['POST'])]
    public function index(InformationInput $input): JsonResponse
    {
        return $this->json($this->info->products($input->getEnvironment()));
    }

    #[Route('/nationalities', name: 'app_information_nationalities', methods: ['POST'])]
    public function nationalities(InformationInput $input): JsonResponse {
        return $this->json($this->info->nationalities($input->getEnvironment()));
    }

    #[Route('/provinces', name: 'app_information_provinces', methods: ['POST'])]
    public function provinces(InformationInput $input): JsonResponse {
        return $this->json($this->info->provinces($input->getEnvironment()));
    }

    #[Route('/commercialOffices', name: 'app_information_commercial_offices', methods: ['POST'])]
    public function commercialOffices(InformationInput $input): JsonResponse {
        return $this->json($this->info->commercialOffices($input));
    }
}
