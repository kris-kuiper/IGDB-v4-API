<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Request;

use KrisKuiper\IGDBV4\Exceptions\AuthenticationException;
use KrisKuiper\IGDBV4\Exceptions\RequestException;

class WebhookRequest extends AbstractRequest
{
    /**
     * Registers a webhook for the given endpoint and returns the raw webhook object.
     *
     * @throws RequestException|AuthenticationException
     */
    public function register(string $endpoint, string $url, string $method, string $secret): object
    {
        $response = $this->send(self::HTTP_POST, $endpoint . '/webhooks/', [
            'form_params' => [
                'url' => $url,
                'method' => $method,
                'secret' => $secret,
            ],
        ]);

        return (object) $this->decode($response);
    }

    /**
     * Returns every registered webhook as a list of raw webhook objects.
     *
     * @throws RequestException|AuthenticationException
     */
    public function all(): array
    {
        $decoded = $this->decode($this->send(self::HTTP_GET, 'webhooks/'));

        return is_array($decoded) ? $decoded : [$decoded];
    }

    /**
     * Returns a single registered webhook by its identifier, or null when it does not exist.
     *
     * @throws RequestException|AuthenticationException
     */
    public function find(int $id): ?object
    {
        $decoded = $this->decode($this->send(self::HTTP_GET, 'webhooks/' . $id));

        if (true === is_array($decoded)) {
            return $decoded[0] ?? null;
        }

        return $decoded;
    }

    /**
     * Removes a registered webhook and returns the identifier echoed back by IGDB as confirmation.
     *
     * @throws RequestException|AuthenticationException
     */
    public function delete(int $id): int
    {
        $decoded = (object) $this->decode($this->send(self::HTTP_DELETE, 'webhooks/' . $id));

        if (true === property_exists($decoded, 'id')) {
            return (int) $decoded->id;
        }

        return $id;
    }

    /**
     * Asks IGDB to deliver the entity to the registered webhook for testing purposes.
     *
     * @throws RequestException|AuthenticationException
     */
    public function test(string $endpoint, int $webhookId, int $entityId): void
    {
        $this->send(self::HTTP_POST, $endpoint . '/webhooks/test/' . $webhookId, [
            'query' => ['entityId' => $entityId],
        ]);
    }
}
