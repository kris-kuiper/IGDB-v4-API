<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class ScreenshotEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'screenshots';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
