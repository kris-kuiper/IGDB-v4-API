<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class LanguageSupportEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'language_supports';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
