<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class DateFormatEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'date_formats';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
