<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class LanguageEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'languages';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
