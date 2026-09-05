<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

/**
 * @deprecated IGDB deprecated this endpoint in favour of the image type endpoint.
 */
class ArtworkTypeEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'artwork_types';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
