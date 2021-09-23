<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class FranchiseEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'franchises';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
