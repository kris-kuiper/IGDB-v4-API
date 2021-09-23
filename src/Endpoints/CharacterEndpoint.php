<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class CharacterEndpoint extends AbstractSearchEndpoint
{
    public const ENDPOINT = 'characters';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
