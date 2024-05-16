<?php 

namespace App\EventListener;

use App\Service\AuthService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;


class AccessListener implements EventSubscriberInterface
{
    public function __construct(
        private AuthService $authService
    ) {
    }

    public function onKernelController(ControllerEvent $event): void
    {
        if (str_contains($event->getRequest()->getPathInfo(), '/api')) {
            $this->authService->validateAuth($event->getRequest());
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}