<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class GameVideoEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'game_videos';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
