<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class PlatformFamilyEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'platform_families';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
