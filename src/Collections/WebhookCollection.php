<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Collections;

use Iterator;
use KrisKuiper\IGDBV4\Webhooks\ValueObjects\Webhook;

/**
 * @implements Iterator<int, Webhook>
 */
class WebhookCollection implements Iterator
{
    /**
     * @var array<int, Webhook>
     */
    private array $items;

    public function __construct(Webhook ...$webhooks)
    {
        $this->items = $webhooks;
    }

    public function append(Webhook $webhook): void
    {
        $this->items[] = $webhook;
    }

    public function first(): ?Webhook
    {
        if (0 === count($this->items)) {
            return null;
        }

        return $this->items[array_key_first($this->items)];
    }

    public function current(): ?Webhook
    {
        $item = current($this->items);

        return false === $item ? null : $item;
    }

    public function key(): ?int
    {
        return key($this->items);
    }

    public function next(): void
    {
        next($this->items);
    }

    public function rewind(): void
    {
        reset($this->items);
    }

    public function valid(): bool
    {
        return null !== $this->key();
    }

    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return array<int, Webhook>
     */
    public function toArray(): array
    {
        return $this->items;
    }
}
