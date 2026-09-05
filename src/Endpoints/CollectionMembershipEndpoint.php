<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class CollectionMembershipEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'collection_memberships';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
