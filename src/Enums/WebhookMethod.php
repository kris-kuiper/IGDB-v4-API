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
     * Matches case-insensitively because IGDB is not consistent in header value casing.
     *
     * @throws WebhookException
     */
    public static function fromOperation(string $operation): self
    {
        return self::tryFrom(strtolower($operation)) ?? throw WebhookException::unknownOperation($operation);
    }
}
