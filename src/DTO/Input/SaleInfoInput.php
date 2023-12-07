<?php

namespace App\DTO\Input;

use App\DTO\Input\InputInterface;

final class SaleInfoInput implements InputInterface
{
    private ?int $orderId;
    private string $transactionId;
    private string $environment;

    /**
     * @param int|null $orderId
     * @param string $transactionId
     */
    public function __construct(?int $orderId, string $transactionId)
    {
        $this->orderId = $orderId;
        $this->transactionId = $transactionId;
    }

    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    public function setOrderId(?int $orderId): void
    {
        $this->orderId = $orderId;
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
}
