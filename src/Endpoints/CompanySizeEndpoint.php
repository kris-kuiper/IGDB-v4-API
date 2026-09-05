<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class CompanySizeEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'company_sizes';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
