<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class AgeRatingContentDescriptionV2Endpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'age_rating_content_descriptions_v2';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
