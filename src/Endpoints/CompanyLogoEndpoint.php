<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class CompanyLogoEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'company_logos';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
