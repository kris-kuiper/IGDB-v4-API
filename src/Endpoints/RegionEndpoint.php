<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class RegionEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'regions';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
