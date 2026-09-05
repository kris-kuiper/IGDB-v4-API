<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class WebsiteTypeEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'website_types';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
