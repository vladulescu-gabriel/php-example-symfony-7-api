<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    public function getLoginUser(string $login): ?User
    {
        return $this->userRepository->searchByLoginVariants($login);
    }

    public function getUserById(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function getAllUsers(): array
    {
        return $this->userRepository->findAll();
    }

    public function addUser(string $email, string $username, string $plainPassword, UserPasswordHasherInterface $hasher): User
    {

        $user = new User();
        $user->setEmail($email)
            ->setUsername($username);

        $encryptedPassword = $hasher->hashPassword($user, $plainPassword);
        $user->setPassword($encryptedPassword);

        $this->userRepository->save($user);

        return $user;
    }
}