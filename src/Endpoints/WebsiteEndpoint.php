<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class WebsiteEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'websites';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
