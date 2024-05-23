<?php

namespace App\Validator;

use App\Entity\Permission;
use App\Entity\StudyClass;
use App\Exception\RequestException;
use App\Service\PermissionService;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;

class NewClassValidator
{
    public function __construct(
        private UserService $userService,
        private PermissionService $permissionService
    ) {
    }
    
    public function validate(Request $request): StudyClass
    {
        $data = json_decode($request->getContent());

        if (!isset($data->class_name)) {
            throw new RequestException('Class Name Required');
        }

        if (!isset($data->owner_id)) {
            throw new RequestException('User Id required for ownership of class');
        }

        $user = $this->userService->getUserById($data->owner_id);

        if (!$user) {
            throw new RequestException('User searched by owner id do not exists');
        }

        $permission = ($user->getRole())->getPermissions()->filter(function(Permission $permission) {
            return $permission->getName() === Permission::ACCESS_STUDY_CLASS_OWNER;
        });

        if (!$permission->first()) {
            throw new RequestException('User required for user to be owner:' . Permission::ACCESS_STUDY_CLASS_OWNER);
        }
        
        $newClass = new StudyClass();
        $newClass->setName($data->class_name)
            ->setClassOwner($user);

        return $newClass;
    }
}