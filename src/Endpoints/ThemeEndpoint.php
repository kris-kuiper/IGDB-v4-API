<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class ThemeEndpoint extends AbstractSearchEndpoint
{
    public const ENDPOINT = 'themes';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
