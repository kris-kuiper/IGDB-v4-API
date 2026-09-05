<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class ReportTypeEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'report_types';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
