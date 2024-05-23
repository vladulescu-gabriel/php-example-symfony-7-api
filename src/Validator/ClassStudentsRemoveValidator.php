<?php

namespace App\Validator;

use App\Exception\RequestException;
use App\Service\PermissionService;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;

class ClassStudentsRemoveValidator
{
    public function __construct(
        private UserService $userService,
        private PermissionService $permissionService
    ) {
    }
    
    public function validate(Request $request): array
    {
        $data = json_decode($request->getContent());

        if (!isset($data->user_ids)) {
            throw new RequestException('User Ids required');
        }

        // verify to be numbers
        foreach ($data->user_ids as $id) {
            if (!is_numeric($id)) {
                throw new RequestException('All Ids needs to be numeric');
            }
        }

        $users = $this->userService->getMultipleById($data->user_ids);

        // get all user ids
        $userIds = [];
        foreach ($users as $user) {
            $userIds[] = $user->getId();
        }

        // compare ids for missing users
        $missingIds = [];
        foreach ($data->user_ids as $id) {
            if (!in_array($id, $userIds)) {
                $missingIds[] = $id;
            }
        }

        if (count($missingIds) > 0) {
            throw new RequestException('Some user could not be found, ids: '. implode($missingIds));
        }

        return $users;
    }
}