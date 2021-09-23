<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class GameVersionFeatureEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'game_version_features';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
