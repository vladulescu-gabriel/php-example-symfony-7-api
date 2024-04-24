<?php 

namespace App\EventListener;

use App\Controller\TokenAuthenticatedController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;


class MiddlewareListener implements EventSubscriberInterface
{
    public function __construct(

    ) {
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();

        $routeOptions = $event->getRequest()->attributes;

//        $middleware = $routeOptions['middleware'] ?? null;

       // dd($event);
        // when a controller class defines multiple action methods, the controller
        // is returned as [$controllerInstance, 'methodName']
        if (is_array($controller)) {
            $controller = $controller[0];
        }

        // if ($controller instanceof TokenAuthenticatedController) {
        //     $token = $event->getRequest()->query->get('token');
        //     if (!in_array($token, $this->tokens)) {
        //         throw new AccessDeniedHttpException('This action needs a valid token!');
        //     }
        // }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}