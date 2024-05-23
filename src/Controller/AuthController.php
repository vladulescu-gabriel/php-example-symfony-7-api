<?php

namespace App\Controller;

use App\Service\AuthService;
use App\Service\UserService;
use App\Validator\LoginValidator;
use App\Validator\RegisterValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;     
use Symfony\Component\HttpFoundation\Response;
use App\Processor\ResponseProcessor;

class AuthController extends AbstractController
{
    public function __construct(
        private AuthService $authService,
        private UserService $userService,
        private LoginValidator $loginValidator,
        private RegisterValidator $registerValidator
    ) {
    }

    #[Route('/signup', methods: ['POST'])]
    public function register(Request $request): Response
    {
        $requestUser = $this->registerValidator->validate($request);
        $newUser = $this->userService->addUser($requestUser);
        $token = $this->authService->setAuthUser($newUser);

        return ResponseProcessor::send([
            "Token" => $token
        ]);
    }

    #[Route('/signin', methods: ['POST'])]
    public function login(Request $request): Response
    {
        $user = $this->loginValidator->validate($request);
        $token = $this->authService->setAuthUser($user);

        return ResponseProcessor::send([
            "Token" => $token
        ]);
    }
}