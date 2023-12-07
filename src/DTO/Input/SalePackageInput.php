<?php

namespace App\DTO\Input;

use App\DTO\Input\InputInterface;

final class SalePackageInput implements InputInterface
{
    private ?PackageData $packageInfo;
    private ?ClientInput $client;
    private string $transactionId;
    private string $environment;
    private string $phoneNumber;

    /**
     * @param PackageData|null $packageInfo
     * @param ClientInput|null $client
     * @param string $transactionId
     */
    public function __construct(?PackageData $packageInfo, ?ClientInput $client, string $transactionId)
    {
        $this->packageInfo = $packageInfo;
        $this->client = $client;
        $this->transactionId = $transactionId;
    }

    public function getPackageInfo(): ?PackageData
    {
        return $this->packageInfo;
    }

    public function setPackageInfo(?PackageData $packageInfo): void
    {
        $this->packageInfo = $packageInfo;
    }

    public function getClient(): ?ClientInput
    {
        return $this->client;
    }

    public function setClient(?ClientInput $client): void
    {
        $this->client = $client;
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function setTransactionId(string $transactionId): void
    {
        $this->transactionId = $transactionId;
    }

    public function getEnvironment(): string
    {
        return $this->environment;
    }

    public function setEnvironment(string $environment): void
    {
        $this->environment = $environment;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }
}
