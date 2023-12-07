<?php

namespace App\DTO\Input;

final class RechargeInput implements InputInterface
{
    private string $phoneNumber;
    private int $productCode;
    private float $productPrice;
    private string $transactionId;
    private string $environment;

    /**
     * @param string $phoneNumber
     * @param int $productCode
     * @param float $productPrice
     */
    public function __construct(string $phoneNumber, int $productCode, float $productPrice)
    {
        $this->phoneNumber = $phoneNumber;
        $this->productCode = $productCode;
        $this->productPrice = $productPrice;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getProductCode(): int
    {
        return $this->productCode;
    }

    public function setProductCode(int $productCode): void
    {
        $this->productCode = $productCode;
    }

    public function getProductPrice(): float
    {
        return $this->productPrice;
    }

    public function setProductPrice(float $productPrice): void
    {
        $this->productPrice = $productPrice;
    }

    public function getEnvironment(): string
    {
        return $this->environment;
    }

    public function setEnvironment(string $environment): void
    {
        $this->environment = $environment;
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function setTransactionId(string $transactionId): void
    {
        $this->transactionId = $transactionId;
    }
}
