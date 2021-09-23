<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class SearchEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'search';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
