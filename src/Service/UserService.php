<?php

namespace App\Service;

use App\Entity\User;
use App\Processor\SerializeProcessor;
use App\Repository\UserRepository;
use App\Service\RoleService;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private RoleService $roleService,
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private SerializeProcessor $serializer
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

    public function getMultipleById(array $ids): array
    {
        return $this->userRepository->findAllByIds($ids);
    }

    public function addUser(User $newUser): User
    {
        $encryptedPassword = $this->passwordHasher->hashPassword($newUser, $newUser->getPlainPassword());
        $newUser->setPassword($encryptedPassword)
            ->eraseCredentials();

        if (!$newUser->getRole() instanceof Role) {
            $newUser->setRole($this->roleService->getDefaultRole());
        }

        $this->userRepository->save($newUser);

        return $newUser;
    }

    public function updateUser(User $user): User
    {
        $this->userRepository->save($user);

        return $user;
    }
}