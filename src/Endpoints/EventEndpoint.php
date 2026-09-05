<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class EventEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'events';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
