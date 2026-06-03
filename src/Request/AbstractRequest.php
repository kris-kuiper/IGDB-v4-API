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

abstract class AbstractRequest
{
    protected const BASE_URL = 'https://api.igdb.com/v4/';
    protected const HTTP_GET = 'GET';
    protected const HTTP_POST = 'POST';
    protected const HTTP_DELETE = 'DELETE';

    private Client $client;
    private AccessConfigInterface $config;

    public function __construct(Client $client, AccessConfigInterface $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * Performs an authenticated request and translates transport failures into domain exceptions.
     *
     * @throws RequestException|AuthenticationException
     */
    protected function send(string $method, string $path, array $options = []): ResponseInterface
    {
        $options['headers'] = array_merge([
            'Client-ID' => $this->config->getClientId(),
            'Authorization' => 'bearer ' . $this->config->getAccessToken(),
        ], $options['headers'] ?? []);

        try {
            return $this->client->request($method, self::BASE_URL . $path, $options);
        } catch (ClientExceptionInterface $exception) {
            throw match ($exception->getCode()) {
                400 => RequestException::badSyntax($path, $exception),
                401 => AuthenticationException::authenticationFailed($exception),
                404 => RequestException::endpointNotFound($path),
                default => RequestException::unknownError($path, $exception),
            };
        }
    }

    /**
     * Decodes a JSON response body into a stdClass object or a list of stdClass objects.
     *
     * @throws RequestException
     */
    protected function decode(ResponseInterface $response): array|object
    {
        $contents = $response->getBody()->getContents();

        try {
            return json_decode($contents, false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            throw RequestException::unknownResponseFormat($contents);
        }
    }
}
