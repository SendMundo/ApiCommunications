<?php

namespace App\Entity;

use App\Repository\ConnectionSessionRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ConnectionSessionRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(
    name: "uniqueSessionByTunnel",
    fields: ["sessionIdentification", "tunnelType"]
)]
class ConnectionSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $closedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $sessionIdentification = null;

    #[ORM\Column(length: 15)]
    private ?string $tunnelType = null;

    #[ORM\Column(nullable: true)]
    private ?float $balance = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getClosedAt(): ?DateTimeImmutable
    {
        return $this->closedAt;
    }

    public function setClosedAt(?DateTimeImmutable $closedAt): static
    {
        $this->closedAt = $closedAt;

        return $this;
    }

    public function getSessionIdentification(): ?string
    {
        return $this->sessionIdentification;
    }

    public function setSessionIdentification(string $sessionIdentification): static
    {
        $this->sessionIdentification = $sessionIdentification;

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

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(?float $balance): static
    {
        $this->balance = $balance;

        return $this;
    }
}
