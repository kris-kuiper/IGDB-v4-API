<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class CollectionMembershipTypeEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'collection_membership_types';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
