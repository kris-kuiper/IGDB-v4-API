<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class PlatformEndpoint extends AbstractSearchEndpoint
{
    public const ENDPOINT = 'platforms';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
