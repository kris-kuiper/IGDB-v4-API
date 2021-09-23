<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class GameEngineLogoEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'game_engine_logos';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
