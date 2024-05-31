<?php

namespace App\Validator;

use App\Entity\User;
use App\Exception\RequestException;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;

class RegisterValidator
{
    public function __construct(
        private UserService $userService
    ) {}
    
    public function validate(Request $request): User
    {
        $data = json_decode($request->getContent());
        
        if (!$data->email || !$data->username || !$data->password) {
            throw new RequestException('Login and password required');
        }
        
        if (strlen($data->password) < 8) {
            throw new RequestException('Password needs to be more or equal with 8 characters');
        }

        $existingUser = $this->userService->getLoginUserByBothVariants($data->username, $data->email);

        if ($existingUser instanceof User) {
            throw new RequestException('Email or Username already used');
        }

        $newUser = new User();
        $newUser->setEmail($data->email)
            ->setUsername($data->username)
            ->setPlainPassword($data->password);

        return $newUser;
    }
}