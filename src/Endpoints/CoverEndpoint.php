<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class CoverEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'covers';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
