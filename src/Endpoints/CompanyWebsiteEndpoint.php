<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class CompanyWebsiteEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'company_websites';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
