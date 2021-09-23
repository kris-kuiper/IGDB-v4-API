<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class AlternativeNameEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'alternative_names';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
