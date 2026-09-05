<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class ExternalGameSourceEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'external_game_sources';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
