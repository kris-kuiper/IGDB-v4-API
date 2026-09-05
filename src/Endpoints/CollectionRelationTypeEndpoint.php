<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class CollectionRelationTypeEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'collection_relation_types';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
