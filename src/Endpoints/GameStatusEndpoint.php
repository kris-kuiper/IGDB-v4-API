<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class GameStatusEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'game_statuses';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
