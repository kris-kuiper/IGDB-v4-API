<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class EventLogoEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'event_logos';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
