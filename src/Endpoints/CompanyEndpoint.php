<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class CompanyEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'companies';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
