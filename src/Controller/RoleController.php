<?php

namespace App\Controller;

use App\Entity\Permission;
use App\Processor\SerializeProcessor;
use App\Service\RoleService;
use App\Validator\NewRoleValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;     
use Symfony\Component\HttpFoundation\Response;
use App\Processor\ResponseProcessor;

class RoleController extends AbstractController
{
    public function __construct(
        private NewRoleValidator $newRoleValidator,
        private RoleService $roleService,
        private SerializeProcessor $serializer
    ) {
    }

    #[Route(
        '/api/roles',
        methods: ['GET'],
        options: [Permission::PERMISSION_KEY => Permission::ACCESS_VIEW_ROLES]
    )]
    public function getAll(Request $request): Response
    {
        $roles = $this->roleService->getAllRoles();
        $data = $this->serializer->serialize($roles);
        return ResponseProcessor::send($data);
    }

    #[Route(
        '/api/roles/{roleId}',
        methods: ['GET'],
        options: [Permission::PERMISSION_KEY => Permission::ACCESS_VIEW_ROLE]
    )]
    public function getOne(Request $request, int $roleId): Response
    {
        $role = $this->roleService->getOneById($roleId);
        $data = $this->serializer->serialize($role);
        return ResponseProcessor::send($data);
    }

    #[Route(
        '/api/roles',
        methods: ['POST'],
        options: [Permission::PERMISSION_KEY => Permission::ACCESS_ADD_ROLE]
    )]
    public function addOne(Request $request): Response
    {
        $roleName = $this->newRoleValidator->validate($request);
        $role = $this->roleService->addNewRole($roleName);
        $data = $this->serializer->serialize($role);
        
        return ResponseProcessor::send($data);
    }
}