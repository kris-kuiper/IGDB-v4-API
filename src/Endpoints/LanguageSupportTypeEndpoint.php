<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class LanguageSupportTypeEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'language_support_types';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
