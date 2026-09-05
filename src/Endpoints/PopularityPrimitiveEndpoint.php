<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class PopularityPrimitiveEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'popularity_primitives';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
