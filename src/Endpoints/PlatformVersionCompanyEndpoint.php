<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class PlatformVersionCompanyEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'platform_version_companies';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
