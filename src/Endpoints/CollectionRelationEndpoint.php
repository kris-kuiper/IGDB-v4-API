<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class CollectionRelationEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'collection_relations';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
