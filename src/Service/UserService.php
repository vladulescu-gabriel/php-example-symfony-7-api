<?php

namespace App\Service;

use App\Model\User;
use App\Repository\UserRepository;

class UserService
{
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    public function getLoginUser(string $login): User
    {
        return $this->userRepository->searchByLoginVariants($login);
    }
}