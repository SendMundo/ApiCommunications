<?php

namespace App\Entity;

use App\Repository\OperationRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OperationRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Operation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $connectionId = null;

    #[ORM\Column]
    private array $operationInfo = [];

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?array $responseInfo = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $transactionInfo = null;

    #[ORM\Column(length: 255)]
    private ?string $tunnelType = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $orderId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $keyInfo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConnectionId(): ?string
    {
        return $this->connectionId;
    }

    public function setConnectionId(string $connectionId): static
    {
        $this->connectionId = $connectionId;

        return $this;
    }

    public function getOperationInfo(): array
    {
        return $this->operationInfo;
    }

    public function setOperationInfo(array $operationInfo): static
    {
        $this->operationInfo = $operationInfo;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getResponseInfo(): ?array
    {
        return $this->responseInfo;
    }

    public function setResponseInfo(?array $responseInfo): static
    {
        $this->responseInfo = $responseInfo;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getTransactionInfo(): ?string
    {
        return $this->transactionInfo;
    }

    public function setTransactionInfo(?string $transactionInfo): static
    {
        $this->transactionInfo = $transactionInfo;

        return $this;
    }

    #[ORM\PrePersist]
    public function onCreated(): void {
        $this->createdAt = new DateTimeImmutable('now');
    }

    public function getTunnelType(): ?string
    {
        return $this->tunnelType;
    }

    public function setTunnelType(string $tunnelType): static
    {
        $this->tunnelType = $tunnelType;

        return $this;
    }

    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    public function setOrderId(?string $orderId): static
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function getKeyInfo(): ?string
    {
        return $this->keyInfo;
    }

    public function setKeyInfo(?string $keyInfo): static
    {
        $this->keyInfo = $keyInfo;

        return $this;
    }
}
