<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class GameReleaseFormatEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'game_release_formats';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
