<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Webhooks\ValueObjects;

use KrisKuiper\IGDBV4\Enums\WebhookMethod;

final class WebhookPayload
{
    private string $endpoint;
    private WebhookMethod $operation;
    private object $data;

    private function __construct()
    {
    }

    /**
     * Normalizes the endpoint to its lowercase slug; IGDB deliveries send
     * "Games" in X-Endpoint while webhooks are registered with the slug "games".
     */
    public static function create(string $endpoint, WebhookMethod $operation, object $data): self
    {
        $instance = new self();
        $instance->endpoint = strtolower($endpoint);
        $instance->operation = $operation;
        $instance->data = $data;

        return $instance;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function getOperation(): WebhookMethod
    {
        return $this->operation;
    }

    /**
     * Returns the unexpanded entity sent by IGDB; for delete notifications only the id is present.
     */
    public function getData(): object
    {
        return $this->data;
    }

    public function getId(): ?int
    {
        if (false === property_exists($this->data, 'id')) {
            return null;
        }

        return (int) $this->data->id;
    }
}
