<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class ImageTypeEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'image_types';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
