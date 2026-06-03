<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Request;

use GuzzleHttp\Client;
use KrisKuiper\IGDBV4\Contracts\AccessConfigInterface;
use KrisKuiper\IGDBV4\Exceptions\AuthenticationException;
use KrisKuiper\IGDBV4\Exceptions\RequestException;

class Request extends AbstractRequest
{
    private string $endpoint;

    public function __construct(Client $client, AccessConfigInterface $config, string $endpoint)
    {
        parent::__construct($client, $config);
        $this->endpoint = $endpoint;
    }

    /**
     * @throws RequestException|AuthenticationException
     */
    public function post(string $body): array
    {
        $response = $this->send(self::HTTP_POST, $this->endpoint, [
            'headers' => ['Content-Type' => 'text/plain'],
            'body' => $body,
        ]);

        return (array) $this->decode($response);
    }
}
