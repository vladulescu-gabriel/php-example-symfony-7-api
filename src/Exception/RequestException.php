<?php

namespace App\Exception;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

final class RequestException extends RuntimeException
{
    public function __construct($message = '')
    {
        parent::__construct($message, Response::HTTP_BAD_REQUEST);
    }
}
