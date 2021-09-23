<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class ArtworkEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'artworks';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
