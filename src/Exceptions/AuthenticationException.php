<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Exceptions;

use Exception;
use Throwable;

class AuthenticationException extends Exception
{
    public static function authenticationFailed(Throwable $previous): self
    {
        return new self('Failed to authenticate', $previous->getCode(), $previous);
    }

    public static function invalidClientSecret(): self
    {
        return new self('Invalid client secret provided');
    }

    public static function invalidClient(): self
    {
        return new self('Invalid client provided');
    }
}
