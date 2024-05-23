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

        // Json Exception handdle
        if ($exception instanceof RuntimeException) {

            $response = new JsonResponse([
                'message'       => $exception->getMessage(),
                'code'          => $exception->getCode(),
                // 'traces'        => $exception->getTrace()
            ]);
            $response->setStatusCode($exception->getCode());

        } else {
            $response = new JsonResponse([
                'message'       => 'Internal Server Error',
                'code'          => Response::HTTP_INTERNAL_SERVER_ERROR,
                // 'traces'        => $exception->getTrace()
            ]);
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }
}