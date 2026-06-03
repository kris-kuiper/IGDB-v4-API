<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Webhooks\ValueObjects;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

final class Webhook
{
    private int $id;
    private string $url;
    private int $category;
    private int $subCategory;
    private bool $active;
    private string $apiKey;
    private string $secret;
    private string $createdAt;
    private string $updatedAt;

    private function __construct()
    {
    }

    /**
     * Builds a webhook from the raw object returned by the IGDB webhook API.
     *
     * @throws InvalidArgumentException
     */
    public static function fromObject(object $data): self
    {
        $data = (array) $data;

        Assert::keyExists($data, 'id');
        Assert::keyExists($data, 'url');
        Assert::keyExists($data, 'category');
        Assert::keyExists($data, 'sub_category');
        Assert::keyExists($data, 'active');
        Assert::keyExists($data, 'api_key');
        Assert::keyExists($data, 'secret');
        Assert::keyExists($data, 'created_at');
        Assert::keyExists($data, 'updated_at');

        $instance = new self();
        $instance->id = (int) $data['id'];
        $instance->url = (string) $data['url'];
        $instance->category = (int) $data['category'];
        $instance->subCategory = (int) $data['sub_category'];
        $instance->active = (bool) $data['active'];
        $instance->apiKey = (string) $data['api_key'];
        $instance->secret = (string) $data['secret'];
        $instance->createdAt = (string) $data['created_at'];
        $instance->updatedAt = (string) $data['updated_at'];

        return $instance;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getCategory(): int
    {
        return $this->category;
    }

    public function getSubCategory(): int
    {
        return $this->subCategory;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }
}
