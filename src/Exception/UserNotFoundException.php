<?php

namespace App\Exception;
use RuntimeException;

final class UserNotFoundException extends RuntimeException
{
    public static function create(string $message): self
    {
        return new self($message);
    }
}
