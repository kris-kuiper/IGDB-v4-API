<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class AgeRatingCategoryEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'age_rating_categories';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
