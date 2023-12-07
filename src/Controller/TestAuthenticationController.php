<?php

namespace App\Controller;

use App\Service\AuthenticationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TestAuthenticationController extends AbstractController
{
    protected AuthenticationService $authenticationService;

    /**
     * @param AuthenticationService $authenticationService
     */
    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    #[Route('/test/authentication', name: 'app_test_authentication')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TestAuthenticationController.php',
            'called' => $this->authenticationService->checkAuthentication("TEST")
        ]);
    }
}
