<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class ReleaseDateStatusEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'release_date_statuses';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
