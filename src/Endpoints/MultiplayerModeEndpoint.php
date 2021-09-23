<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class MultiplayerModeEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'multiplayer_modes';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
