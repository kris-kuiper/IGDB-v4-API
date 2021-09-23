<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class AgeRatingContentDescriptionEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'age_rating_content_descriptions';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
