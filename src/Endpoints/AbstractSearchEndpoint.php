<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

use KrisKuiper\IGDBV4\Contracts\EndpointSearchInterface;
use KrisKuiper\IGDBV4\Exceptions\AuthenticationException;
use KrisKuiper\IGDBV4\Exceptions\RequestException;
use KrisKuiper\IGDBV4\QueryBuilder\Query;

abstract class AbstractSearchEndpoint extends AbstractEndpoint implements EndpointSearchInterface
{
    /**
     * @throws RequestException|AuthenticationException
     */
    public function search(string $name, array $fields = null): array
    {
        $query = (new Query())->fields(...($fields ?? ['*']))->search($name)->build();
        return $this->request()->post($query);
    }
}
