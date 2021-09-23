<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Endpoints;

use GuzzleHttp\Client;
use KrisKuiper\IGDBV4\Contracts\AccessConfigInterface;
use KrisKuiper\IGDBV4\Contracts\EndpointInterface;
use KrisKuiper\IGDBV4\Exceptions\AuthenticationException;
use KrisKuiper\IGDBV4\Exceptions\RequestException;
use KrisKuiper\IGDBV4\QueryBuilder\Query;
use KrisKuiper\IGDBV4\Request\Request;

abstract class AbstractEndpoint implements EndpointInterface
{
    private Client $client;
    private AccessConfigInterface $config;

    public function __construct(Client $client, AccessConfigInterface $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * @throws RequestException|AuthenticationException
     */
    public function findById(int $id, array $fields = null): array
    {
        $query = (new Query())->fields(...($fields ?? ['*']))->where('id', $id)->build();
        return $this->request()->post($query);
    }

    /**
     * @throws RequestException|AuthenticationException
     */
    public function list(int $offset = 0, int $limit = 500, array $fields = null): array
    {
        $query = (new Query())->fields(...($fields ?? ['*']))->offset($offset)->limit($limit)->build();
        return $this->request()->post($query);
    }

    /**
     * @throws RequestException|AuthenticationException
     */
    public function query(string $query): array
    {
        return $this->request()->post($query);
    }

    protected function request(): Request
    {
        return new Request($this->client, $this->config, $this->getEndpoint());
    }
}
