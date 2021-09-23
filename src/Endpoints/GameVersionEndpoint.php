<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class GameVersionEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'game_versions';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
