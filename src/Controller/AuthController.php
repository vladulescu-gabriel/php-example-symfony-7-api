<?php

namespace App\Controller;

use App\Exception\RequestException;
use App\Service\AuthService;
use App\Service\UserService;
use App\Validator\LoginValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;     
use Symfony\Component\HttpFoundation\Response;
use App\Processor\ResponseProcessor;

class AuthController extends AbstractController
{
    public function __construct(
        private AuthService $authService,
        private UserService $userService,
        private LoginValidator $loginValidator
    ) {
    }

    #[Route('/signup', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $data = json_decode($request->getContent());
        
        if (!$data->email || !$data->username || !$data->password) {
            throw new RequestException('Login and password required');
        }

        $newUser = $this->userService->addUser($data->email, $data->username, $data->password, $passwordHasher);
        $token = $this->authService->setAuthUser($newUser);

        return ResponseProcessor::send([
            "Auth Token" => $token
        ]);
    }

    #[Route('/signin', methods: ['POST'])]
    public function login(Request $request): Response
    {
        $user = $this->loginValidator->validate($request);
        $token = $this->authService->setAuthUser($user);

        return ResponseProcessor::send([
            "AuthToken" => $token
        ]);
    }
}