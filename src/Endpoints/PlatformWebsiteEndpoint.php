<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class PlatformWebsiteEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'platform_websites';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
