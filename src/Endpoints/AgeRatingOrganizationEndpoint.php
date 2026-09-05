<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class AgeRatingOrganizationEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'age_rating_organizations';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
