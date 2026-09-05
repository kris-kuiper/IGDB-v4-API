<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class EventNetworkEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'event_networks';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
