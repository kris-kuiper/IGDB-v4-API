<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

class InvolvedCompanyEndpoint extends AbstractEndpoint
{
    public const ENDPOINT = 'involved_companies';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
