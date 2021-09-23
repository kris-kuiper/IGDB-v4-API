<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class GameVersionFeatureValueEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'game_version_feature_values';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
