<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class GameLocalizationEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'game_localizations';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
