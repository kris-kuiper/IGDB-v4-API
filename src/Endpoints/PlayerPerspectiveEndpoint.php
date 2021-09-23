<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class PlayerPerspectiveEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'player_perspectives';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
