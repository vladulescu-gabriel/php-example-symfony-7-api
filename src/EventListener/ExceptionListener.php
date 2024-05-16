<?php 

namespace App\EventListener;

use RuntimeException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $request   = $event->getRequest();

        // Only for api part
        if ('application/json' === $request->headers->get('Content-Type'))
        {
            $response = new JsonResponse([
                'message'       => $exception->getMessage(),
                'code'          => $exception->getCode(),
                // 'traces'        => $exception->getTrace()
            ]);

            if ($exception instanceof RuntimeException) {
                $response->setStatusCode($exception->getCode());
            } else {
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $event->setResponse($response);
        }
    }
}