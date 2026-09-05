<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class NetworkTypeEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'network_types';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
