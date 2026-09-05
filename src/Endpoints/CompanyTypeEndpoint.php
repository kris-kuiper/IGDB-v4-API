<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class CompanyTypeEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'company_types';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
