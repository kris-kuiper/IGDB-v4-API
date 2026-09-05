<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

/**
 * @deprecated IGDB deprecated this endpoint in favour of the version 2 endpoint.
 */
class AgeRatingContentDescriptionEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'age_rating_content_descriptions';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
