<?php

namespace App\DTO\Output;

use DateTime;

final class GetSaleInfo
{
    private ?int $orderId;
    private ?string $transactionId;
    private ?string $state;
    private ?string $phoneNumber;
    private ?DateTime $createdDateTime;
    private ?DateTime $expiredDateTime;
    private ?DateTime $processedDateTime;
    private ?bool $executedDateTime;
    private ?string $pinCode;
    private ?bool $package;

    /**
     * @param int|null $orderId
     * @param string|null $transactionId
     * @param string|null $state
     * @param string|null $phoneNumber
     * @param DateTime|null $createdDateTime
     * @param DateTime|null $expiredDateTime
     * @param DateTime|null $processedDateTime
     * @param bool|null $executedDateTime
     * @param string|null $pinCode
     * @param bool|null $package
     */
    public function __construct(
        ?int $orderId,
        ?string $transactionId,
        ?string $state,
        ?string $phoneNumber,
        ?DateTime $createdDateTime,
        ?DateTime $expiredDateTime,
        ?DateTime $processedDateTime,
        ?bool $executedDateTime,
        ?string $pinCode,
        ?bool $package
    ) {
        $this->orderId = $orderId;
        $this->transactionId = $transactionId;
        $this->state = $state;
        $this->phoneNumber = $phoneNumber;
        $this->createdDateTime = $createdDateTime;
        $this->expiredDateTime = $expiredDateTime;
        $this->processedDateTime = $processedDateTime;
        $this->executedDateTime = $executedDateTime;
        $this->pinCode = $pinCode;
        $this->package = $package;
    }

    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    public function setOrderId(?string $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }

    public function setTransactionId(?string $transactionId): void
    {
        $this->transactionId = $transactionId;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getCreatedDateTime(): ?DateTime
    {
        return $this->createdDateTime;
    }

    public function setCreatedDateTime(?DateTime $createdDateTime): void
    {
        $this->createdDateTime = $createdDateTime;
    }

    public function getExpiredDateTime(): ?DateTime
    {
        return $this->expiredDateTime;
    }

    public function setExpiredDateTime(?DateTime $expiredDateTime): void
    {
        $this->expiredDateTime = $expiredDateTime;
    }

    public function getProcessedDateTime(): ?DateTime
    {
        return $this->processedDateTime;
    }

    public function setProcessedDateTime(?DateTime $processedDateTime): void
    {
        $this->processedDateTime = $processedDateTime;
    }

    public function getExecutedDateTime(): ?bool
    {
        return $this->executedDateTime;
    }

    public function setExecutedDateTime(?bool $executedDateTime): void
    {
        $this->executedDateTime = $executedDateTime;
    }

    public function getPinCode(): ?string
    {
        return $this->pinCode;
    }

    public function setPinCode(?string $pinCode): void
    {
        $this->pinCode = $pinCode;
    }

    public function getPackage(): ?bool
    {
        return $this->package;
    }

    public function setPackage(?bool $package): void
    {
        $this->package = $package;
    }
}
