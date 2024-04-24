<?php

namespace App\Validator;

use App\Service\UserService;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class LoginValidator
{
    public function __construct(
        private UserService $userService,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }
    
    public function validate(Request $request): UserInterface
    {
        $login = $request->getPayload()->get('login');
        $password = $request->getPayload()->get('password');
        
        if (!$password || !$login) {
            throw new Exception('Authentication data not provided');
        }

        $user = $this->userService->getLoginUser($login);

        if (!$user) {
            throw new Exception('User not found');
        }

        if (!$this->passwordHasher->isPasswordValid($user, $password)) {
            throw new Exception('Invalid password');
        }

        return $user;
    }
}