<?php

namespace App\Validator;

use App\Entity\User;
use App\Exception\RequestException;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginValidator
{
    public function __construct(
        private UserService $userService,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }
    
    public function validate(Request $request): User
    {
        $data = json_decode($request->getContent());
        $login = $data->login;
        $password = $data->password;
        
        if (!$password || !$login) {
            throw new RequestException('Authentication data not provided');
        }

        $user = $this->userService->getLoginUser($login);

        if (!$user) {
            throw new RequestException('User not found');
        }

        if (!$this->passwordHasher->isPasswordValid($user, $password)) {
            throw new RequestException('Invalid password');
        }

        return $user;
    }
}