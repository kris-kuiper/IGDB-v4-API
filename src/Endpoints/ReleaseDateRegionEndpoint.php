<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class ReleaseDateRegionEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'release_date_regions';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
