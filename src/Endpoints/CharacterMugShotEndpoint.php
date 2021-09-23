<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class CharacterMugShotEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'character_mug_shots';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
