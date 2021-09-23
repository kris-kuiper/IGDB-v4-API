<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class CollectionEndpoint extends AbstractSearchEndpoint
{
    public const ENDPOINT = 'collections';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
