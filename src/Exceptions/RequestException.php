<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Exceptions;

use Exception;
use Psr\Http\Client\ClientExceptionInterface;

class RequestException extends Exception
{
    public static function endpointNotFound(string $endpoint): self
    {
        return new self(sprintf('Provided endpoint "%s" not found', $endpoint));
    }

    public static function unknownResponseFormat(string $response): self
    {
        return new self(sprintf('Response could not be formatted. Response: "%s"', $response));
    }

    public static function unknownError(string $endpoint, Exception|ClientExceptionInterface $exception): self
    {
        return new self(sprintf('Unknown error for endpoint "%s"', $endpoint), $exception->getCode(), $exception);
    }

    public static function badSyntax(string $endpoint, Exception|ClientExceptionInterface $exception): self
    {
        return new self(sprintf('Bad syntax for endpoint "%s"', $endpoint), $exception->getCode(), $exception);
    }
}
