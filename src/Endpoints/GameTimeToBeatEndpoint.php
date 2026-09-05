<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class GameTimeToBeatEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'game_time_to_beats';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
