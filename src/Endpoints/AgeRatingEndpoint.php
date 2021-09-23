<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class AgeRatingEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'age_ratings';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
