<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class CharacterGenderEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'character_genders';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
