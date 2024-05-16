<?php

namespace App\Controller;

use App\Service\AuthService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;     
use Symfony\Component\HttpFoundation\Response;
use App\Processor\ResponseProcessor;

class UserController extends AbstractController
{
    public function __construct(
        private AuthService $authService,
        private UserService $userService
    ) {
    }

    #[Route('/api/users', methods: ['GET'])]
    public function getAll(Request $request): Response
    {
        $users = $this->userService->getAllUsers();
        return ResponseProcessor::send($users);
    }
}