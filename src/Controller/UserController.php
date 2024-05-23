<?php

namespace App\Controller;

use App\Entity\Permission;
use App\Exception\RequestException;
use App\Processor\SerializeProcessor;
use App\Service\AuthService;
use App\Service\RoleService;
use App\Service\UserService;
use App\Validator\NewUserValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;     
use Symfony\Component\HttpFoundation\Response;
use App\Processor\ResponseProcessor;

class UserController extends AbstractController
{
    public function __construct(
        private AuthService $authService,
        private UserService $userService,
        private RoleService $roleService,
        private NewUserValidator $newUserValidator,
        private SerializeProcessor $serializer
    ) {
    }

    #[Route(
        '/api/users',
        methods: ['GET'],
        options: [Permission::PERMISSION_KEY => Permission::ACCESS_VIEW_USERS]
    )]
    public function getAll(Request $request): Response
    {
        $users = $this->userService->getAllUsers();
        $data = $this->serializer->serialize($users);
        return ResponseProcessor::send($data);
    }

    #[Route(
        '/api/users/{userId}',
        methods: ['GET'],
        options: [Permission::PERMISSION_KEY => Permission::ACCESS_VIEW_USER]
    )]
    public function getOne(Request $request, int $userId): Response
    {
        $user = $this->userService->getUserById($userId);
        $data = $this->serializer->serialize($user);
        return ResponseProcessor::send($data);
    }

    #[Route(
        '/api/users',
        methods: ['POST'],
        options: [Permission::PERMISSION_KEY => Permission::ACCESS_ADD_USER]
    )]
    public function newUser(Request $request): Response
    {
        $user = $this->newUserValidator->validate($request);
        $newUser = $this->userService->addUser($user);
        $data = $this->serializer->serialize($newUser);
        
        return ResponseProcessor::send($data);
    }

    #[Route(
        '/api/users/{userId}/{newRole}',
        methods: ['PUT'],
        options: [Permission::PERMISSION_KEY => Permission::ACCESS_CHANGE_ROLE]
    )]
    public function changeRole(Request $request, int $userId, string $newRole): Response
    {
        $user = $this->userService->getUserById($userId);
        $role = $this->roleService->getOneByName($newRole);

        if (!$role) {
            throw new RequestException('Role not found');
        }

        $user->setRole($role);
        $updatedUser = $this->userService->updateUser($user);
        $data = $this->serializer->serialize($updatedUser);
        
        return ResponseProcessor::send($data);
    }
}