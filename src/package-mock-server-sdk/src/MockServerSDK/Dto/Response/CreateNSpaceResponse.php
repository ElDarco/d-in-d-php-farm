<?php

declare(strict_types=1);

namespace CodeTry\MockServerSDK\Dto\Response;

use JMS\Serializer\Annotation as Serializer;

class CreateNSpaceResponse
{
    /**
     * @Serializer\SerializedName("id")
     * @Serializer\Type("string")
     */
    private string $id;

    /**
     * @Serializer\SerializedName("name")
     * @Serializer\Type("string")
     */
    private string $name;

    /**
     * @Serializer\SerializedName("settings")
     * @Serializer\Type("array")
     */
    private array $settings;

    /**
     * @Serializer\SerializedName("requests")
     * @Serializer\Type("array")
     */
    private array $requests;

    /**
     * @Serializer\SerializedName("proxyToUrl")
     * @Serializer\Type("string")
     */
    private string $proxyToUrl;

    /**
     * @Serializer\SerializedName("useProxy")
     * @Serializer\Type("boolean")
     */
    private bool $useProxy;

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSettings(): array
    {
        return $this->settings;
    }

    public function getRequests(): array
    {
        return $this->requests;
    }

    public function getProxyToUrl(): string
    {
        return $this->proxyToUrl;
    }

    public function getUseProxy(): bool
    {
        return $this->useProxy;
    }
}
