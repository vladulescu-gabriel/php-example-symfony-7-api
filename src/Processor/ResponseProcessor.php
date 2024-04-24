<?php

namespace App\Processor;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseProcessor 
{
    public static function send(
        mixed $data,
        int $statusCode = Response::HTTP_OK,
        ?array $headers = null
    ): Response {

        if (empty($headers)) {
            $headers = [
                'Content-Type' => 'application/json'
            ];
        }

        return new JsonResponse($data, $statusCode, $headers);
    }     
    
}