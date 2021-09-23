<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class PlatformLogoEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'platform_logos';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
