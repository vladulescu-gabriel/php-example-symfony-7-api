<?php 

namespace App\EventListener;

use App\Entity\Permission;
use App\Exception\AuthorizationException;
use App\Service\AuthService;
use App\Service\PermissionService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;


class AccessListener implements EventSubscriberInterface
{
    public function __construct(
        private AuthService $authService,
        private PermissionService $permissionService
    ) {
    }

    public function onKernelController(ControllerEvent $event): void
    {
        if (str_contains($event->getRequest()->getPathInfo(), '/api')) {
            $user = $this->authService->validateAuth($event->getRequest());

            $options = $this->getOptions($event);

            if ($options) {
                $permissionRequired = $options[Permission::PERMISSION_KEY];
            }
            
            $hasPermission = $this->permissionService->userHasPermission($user, $permissionRequired);

            if (!$hasPermission) {
                throw new AuthorizationException(
                    'User '
                    . $user->getUsername()
                    . ' of role '
                    . $user->getRole()->getName()
                    . ' needs permission of '
                    . $permissionRequired
                );
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    private function getOptions(ControllerEvent $event): ?array
    {
        $attr = $event->getAttributes();

        foreach ($attr as $at) {
            return $at[0]?->getOptions();
        }

        return null;
    }
}