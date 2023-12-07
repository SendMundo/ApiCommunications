<?php

namespace App\DTO\Input;

use App\DTO\Input\InputInterface;

final class InformationInput implements InputInterface
{
    private string $environment;
    private ?int $provinceId;

    /**
     * @param string $environment
     * @param int|null $provinceId
     */
    public function __construct(string $environment, ?int $provinceId)
    {
        $this->environment = $environment;
        $this->provinceId = $provinceId;
    }

    public function getEnvironment(): string
    {
        return $this->environment;
    }

    public function setEnvironment(string $environment): void
    {
        $this->environment = $environment;
    }

    public function getProvinceId(): ?int
    {
        return $this->provinceId;
    }

    public function setProvinceId(?int $provinceId): void
    {
        $this->provinceId = $provinceId;
    }
}
