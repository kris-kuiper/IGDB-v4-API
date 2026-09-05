<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class EntityTypeEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'entity_types';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
