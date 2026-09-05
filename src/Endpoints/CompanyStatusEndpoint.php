<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class CompanyStatusEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'company_statuses';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
