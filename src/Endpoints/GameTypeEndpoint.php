<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class GameTypeEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'game_types';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
