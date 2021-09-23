<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class ReleaseDateEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'release_dates';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
