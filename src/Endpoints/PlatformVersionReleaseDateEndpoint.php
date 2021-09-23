<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class PlatformVersionReleaseDateEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'platform_version_release_dates';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
