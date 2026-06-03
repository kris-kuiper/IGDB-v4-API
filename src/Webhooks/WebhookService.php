<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Webhooks;

use GuzzleHttp\Client;
use KrisKuiper\IGDBV4\Collections\WebhookCollection;
use KrisKuiper\IGDBV4\Contracts\AccessConfigInterface;
use KrisKuiper\IGDBV4\Contracts\WebhookServiceInterface;
use KrisKuiper\IGDBV4\Enums\WebhookMethod;
use KrisKuiper\IGDBV4\Exceptions\AuthenticationException;
use KrisKuiper\IGDBV4\Exceptions\RequestException;
use KrisKuiper\IGDBV4\Request\WebhookRequest;
use KrisKuiper\IGDBV4\Webhooks\ValueObjects\Webhook;

class WebhookService implements WebhookServiceInterface
{
    private WebhookRequest $request;

    public function __construct(Client $client, AccessConfigInterface $config)
    {
        $this->request = new WebhookRequest($client, $config);
    }

    /**
     * @throws RequestException|AuthenticationException
     */
    public function register(string $endpoint, string $url, WebhookMethod $method, string $secret): Webhook
    {
        return Webhook::fromObject($this->request->register($endpoint, $url, $method->value, $secret));
    }

    /**
     * @throws RequestException|AuthenticationException
     */
    public function all(): WebhookCollection
    {
        $collection = new WebhookCollection();

        foreach ($this->request->all() as $webhook) {
            $collection->append(Webhook::fromObject($webhook));
        }

        return $collection;
    }

    /**
     * @throws RequestException|AuthenticationException
     */
    public function find(int $id): ?Webhook
    {
        $webhook = $this->request->find($id);

        if (null === $webhook) {
            return null;
        }

        return Webhook::fromObject($webhook);
    }

    /**
     * @throws RequestException|AuthenticationException
     */
    public function delete(int $id): int
    {
        return $this->request->delete($id);
    }

    /**
     * @throws RequestException|AuthenticationException
     */
    public function test(string $endpoint, int $webhookId, int $entityId): void
    {
        $this->request->test($endpoint, $webhookId, $entityId);
    }
}
