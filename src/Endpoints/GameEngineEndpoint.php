<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class GameEngineEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'game_engines';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
