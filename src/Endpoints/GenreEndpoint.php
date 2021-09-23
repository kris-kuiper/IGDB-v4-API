<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class GenreEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'genres';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
