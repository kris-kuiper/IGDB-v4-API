<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class GameModeEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'game_modes';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
