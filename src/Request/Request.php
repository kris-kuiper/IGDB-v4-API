<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Request;

use GuzzleHttp\Client;
use JsonException;
use KrisKuiper\IGDBV4\Contracts\AccessConfigInterface;
use KrisKuiper\IGDBV4\Exceptions\AuthenticationException;
use KrisKuiper\IGDBV4\Exceptions\RequestException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;

class Request
{
    private const BASE_URL = 'https://api.igdb.com/v4/';
    private const HTTP_POST = 'post';

    private string $endpoint;
    private Client $client;
    private AccessConfigInterface $config;

    public function __construct(Client $client, AccessConfigInterface $config, string $endpoint)
    {
        $this->client = $client;
        $this->endpoint = $endpoint;
        $this->config = $config;
    }

    /**
     * @throws RequestException|AuthenticationException
     */
    public function post(string $body): array
    {
        $contents = $this->request(self::HTTP_POST, $body)->getBody()->getContents();

        try {
            return json_decode($contents, false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            throw RequestException::unknownResponseFormat($contents);
        }
    }

    /**
     * @throws RequestException|AuthenticationException
     */
    private function request(string $methodType, string $body): ResponseInterface
    {
        try {
            return $this->client->request($methodType, self::BASE_URL . $this->endpoint, [
                'headers' => [
                    'Client-ID' => $this->config->getClientId(),
                    'Authorization' => 'bearer ' . $this->config->getAccessToken(),
                    'Content-Type' => 'text/plain',
                ],
                'body' => $body,
            ]);
        } catch (ClientExceptionInterface $exception) {
            throw match ($exception->getCode()) {
                400 => RequestException::badSyntax($this->endpoint, $exception),
                401 => AuthenticationException::authenticationFailed($exception),
                404 => RequestException::endpointNotFound($this->endpoint),
                default => RequestException::unknownError($this->endpoint, $exception),
            };
        }
    }
}
