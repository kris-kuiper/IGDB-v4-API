<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Enums;

use KrisKuiper\IGDBV4\Exceptions\WebhookException;

enum WebhookMethod: string
{
    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';

    /**
     * Resolves the method from an incoming webhook X-Operation header value.
     *
     * @throws WebhookException
     */
    public static function fromOperation(string $operation): self
    {
        return self::tryFrom($operation) ?? throw WebhookException::unknownOperation($operation);
    }
}
