<?php

namespace App\Validator;

use App\Entity\User;
use App\Exception\RequestException;
use App\Service\RoleService;
use Symfony\Component\HttpFoundation\Request;

class NewUserValidator
{
    public function __construct(
        private RoleService $roleService
    ) {
    }
    
    public function validate(Request $request): User
    {
        $data = json_decode($request->getContent());

        if (!isset($data->username) || !isset($data->email) || !isset($data->password)) {
            throw new RequestException('Username, email and password are required, role is optional');
        }

        if (strlen($data->username) < 5) {
            throw new RequestException('Username needs to be more or equal with 5 characters');
        }

        if (strlen($data->password) < 8) {
            throw new RequestException('Password needs to be more ore equal with 8 characters');
        }

        $newUser = new User();
        $newUser->setEmail($data->email)
            ->setUsername($data->username)
            ->setPlainPassword($data->password);

        if (isset($data->role)) {
            $role = $this->roleService->getOneByName($data->role);

            if (!$role) {
                throw new RequestException('Role passed to new user do not exists');
            }

            $newUser->setRole($role);
        }

        return $newUser;
    }
}