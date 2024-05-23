<?php

namespace App\Validator;

use App\Exception\RequestException;
use App\Service\RoleService;
use Symfony\Component\HttpFoundation\Request;

class NewRoleValidator
{
    public function __construct(
        private RoleService $roleService
    ) {
    }
    
    public function validate(Request $request): string
    {
        $data = json_decode($request->getContent());
        $roleName = isset($data->name) ? $data->name : null;

        if (!$roleName) {
            throw new RequestException('Role Name required in body');
        }

        $role = $this->roleService->getOneByName($roleName);

        if ($role) {
            throw new RequestException('Role already exists');
        }

        return $roleName;
    }
}