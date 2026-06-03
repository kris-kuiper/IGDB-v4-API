<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Contracts;

use KrisKuiper\IGDBV4\Collections\WebhookCollection;
use KrisKuiper\IGDBV4\Enums\WebhookMethod;
use KrisKuiper\IGDBV4\Webhooks\ValueObjects\Webhook;

interface WebhookServiceInterface
{
    public function register(string $endpoint, string $url, WebhookMethod $method, string $secret): Webhook;

    public function all(): WebhookCollection;

    public function find(int $id): ?Webhook;

    public function delete(int $id): int;

    public function test(string $endpoint, int $webhookId, int $entityId): void;
}
