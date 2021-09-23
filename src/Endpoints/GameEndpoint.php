<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class GameEndpoint extends AbstractSearchEndpoint
{
    public const ENDPOINT = 'games';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
