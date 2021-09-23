<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class PlatformVersionEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'platform_versions';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
