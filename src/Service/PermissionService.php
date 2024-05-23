<?php

namespace App\Service;

use App\Entity\Permission;
use App\Entity\User;
use App\Repository\PermissionRepository;

class PermissionService
{
    public function __construct(
        private PermissionRepository $permissionRepository
    ) {
    }

    public function findOneById(int $id): Permission
    {
        return $this->permissionRepository->find($id);   
    }

    public function userHasPermission(User $user, string $permissionRequired): bool
    {
        $hasPermission = false;
        $permissions = ($user->getRole())->getPermissions()->getValues();

        foreach ($permissions as $permission) {
            if ($permission->getName() === $permissionRequired) {
                $hasPermission = true;
                break;
            }
        }
        return $hasPermission;
    }
}