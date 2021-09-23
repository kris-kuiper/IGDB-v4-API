<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class KeywordEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'keywords';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
