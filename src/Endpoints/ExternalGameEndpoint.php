<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class ExternalGameEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'external_games';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
