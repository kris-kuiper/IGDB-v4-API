<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Request;

use GuzzleHttp\ClientInterface;
use KrisKuiper\IGDBV4\Contracts\AccessConfigInterface;
use KrisKuiper\IGDBV4\Exceptions\AuthenticationException;
use KrisKuiper\IGDBV4\Exceptions\RequestException;
use Psr\Http\Message\ResponseInterface;

class Request extends AbstractRequest
{
    private string $endpoint;

    public function __construct(ClientInterface $client, AccessConfigInterface $config, string $endpoint)
    {
        parent::__construct($client, $config);
        $this->endpoint = $endpoint;
    }

    /**
     * @throws RequestException|AuthenticationException
     */
    public function post(string $body): array
    {
        return (array) $this->decode($this->apicalypse($body));
    }

    /**
     * Returns the amount of records reported by a counting endpoint.
     *
     * @throws RequestException|AuthenticationException
     */
    public function count(string $body): int
    {
        $decoded = (object) $this->decode($this->apicalypse($body));

        if (false === property_exists($decoded, 'count')) {
            throw RequestException::unknownResponseFormat((string) json_encode($decoded));
        }

        return (int) $decoded->count;
    }

    /**
     * Sends an apicalypse query as the raw body of a POST request.
     *
     * @throws RequestException|AuthenticationException
     */
    private function apicalypse(string $body): ResponseInterface
    {
        return $this->send(self::HTTP_POST, $this->endpoint, [
            'headers' => ['Content-Type' => 'text/plain'],
            'body' => $body,
        ]);
    }
}
