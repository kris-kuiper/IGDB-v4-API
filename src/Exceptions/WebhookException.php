<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Exceptions;

use Exception;

class WebhookException extends Exception
{
    public static function invalidSecret(): self
    {
        return new self('The incoming webhook secret does not match the expected secret');
    }

    public static function invalidUserAgent(string $userAgent): self
    {
        return new self(sprintf('Unexpected webhook user agent "%s"; expected "IGDB-Webhook-Bot"', $userAgent));
    }

    public static function missingHeader(string $header): self
    {
        return new self(sprintf('Required webhook header "%s" is missing', $header));
    }

    public static function unexpectedResponse(string $body): self
    {
        return new self(sprintf('The webhook payload could not be parsed. Body: "%s"', $body));
    }

    public static function unknownOperation(string $operation): self
    {
        return new self(sprintf('Unknown webhook operation "%s"', $operation));
    }
}
