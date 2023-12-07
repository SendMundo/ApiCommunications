<?php

namespace App\DTO\Input;

use App\DTO\Input\InputInterface;

final class PackageData implements InputInterface
{
    private ?string $id;
    private ?string $packageType;

    /**
     * @param string|null $id
     * @param string|null $packageType
     */
    public function __construct(string $id = null, string $packageType = null)
    {
        $this->id = $id;
        $this->packageType = $packageType;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getPackageType(): string
    {
        return $this->packageType;
    }

    public function setPackageType(string $packageType): void
    {
        $this->packageType = $packageType;
    }

}
