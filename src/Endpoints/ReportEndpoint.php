<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class ReportEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'reports';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
