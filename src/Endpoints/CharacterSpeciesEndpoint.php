<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class CharacterSpeciesEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'character_species';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
