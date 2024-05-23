<?php

namespace App\Service;

use App\Entity\Role;
use App\Repository\RoleRepository;

class RoleService
{
    public function __construct(
        private RoleRepository $roleRepository
    ) {
    }

    public function getDefaultRole(): Role
    {
        $defaultRole = $this->roleRepository->findOneByName(Role::DEFAULT_ROLE_NAME);

        if (!$defaultRole) {
            return $this->addNewRole(Role::DEFAULT_ROLE_NAME);
        }

        return $defaultRole;
    }

    public function getAllRoles(): array
    {
        return $this->roleRepository->findAll();
    }

    public function getOneById(string $id): ?Role
    {
        return $this->roleRepository->find($id);
    }

    public function getOneByName(string $name): ?Role
    {
        return $this->roleRepository->findOneByName($name);
    }

    public function addNewRole(string $name): Role
    {
        $newRole = new Role();
        $newRole->setName($name);
        $this->roleRepository->save($newRole);

        return $newRole;
    }
}