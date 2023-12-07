<?php

namespace App\Entity;

use App\Repository\TunnelInformationRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TunnelInformationRepository::class)]
#[ORM\HasLifecycleCallbacks()]
#[ORM\Index(
    fields: ["type", "tunnelUrl"],
    name: "tunnel_idx"
)]
#[ORM\Index(
    fields: ["tunnelUrl"],
    name: "tunnel_url_idx"
)]
class TunnelInformation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    #[ORM\OrderBy(["type" => "ASC"])]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $tunnelUrl = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isActive = null;

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $removedAt = null;

    #[ORM\Column(precision: 2, nullable: true)]
    private ?float $balance = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->type = "PROD";
        $this->balance = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getTunnelUrl(): ?string
    {
        return $this->tunnelUrl;
    }

    public function setTunnelUrl(string $tunnelUrl): static
    {
        $this->tunnelUrl = $tunnelUrl;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): static
    {
        $this->isActive = $isActive;

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

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getRemovedAt(): ?DateTimeImmutable
    {
        return $this->removedAt;
    }

    public function setRemovedAt(?DateTimeImmutable $removedAt): static
    {
        $this->removedAt = $removedAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function onCreated(): void {
        $this->createdAt = new DateTimeImmutable('now');
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
