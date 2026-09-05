<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class AgeRatingContentDescriptionTypeEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'age_rating_content_description_types';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
