<?php

namespace App\DTO\Input;

use App\DTO\Input\InputInterface;
use DateTime;

final class ClientInput implements InputInterface
{
    private ?string $id;
    private ?string $name;
    private ?int $identificationType;
    private ?DateTime $arrivalDate;
    private ?bool $isAirport;
    private ?int $commercialOfficeId;
    private ?int $provinceId;
    private ?int $nationality;

    /**
     * @param string|null $id
     * @param string|null $name
     * @param int|null $identificationType
     * @param DateTime|null $arrivalDate
     * @param bool|null $isAirport
     * @param int|null $commercialOfficeId
     * @param int|null $provinceId
     * @param int|null $nationality
     */
    public function __construct(
        ?string $id,
        ?string $name,
        ?int $identificationType,
        ?DateTime $arrivalDate,
        ?bool $isAirport,
        ?int $commercialOfficeId,
        ?int $provinceId,
        ?int $nationality
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->identificationType = $identificationType;
        $this->arrivalDate = $arrivalDate;
        $this->isAirport = $isAirport;
        $this->commercialOfficeId = $commercialOfficeId;
        $this->provinceId = $provinceId;
        $this->nationality = $nationality;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getIdentificationType(): ?int
    {
        return $this->identificationType;
    }

    public function setIdentificationType(?int $identificationType): void
    {
        $this->identificationType = $identificationType;
    }

    public function getArrivalDate(): ?DateTime
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(?DateTime $arrivalDate): void
    {
        $this->arrivalDate = $arrivalDate;
    }

    public function getIsAirport(): ?bool
    {
        return $this->isAirport;
    }

    public function setIsAirport(?bool $isAirport): void
    {
        $this->isAirport = $isAirport;
    }

    public function getCommercialOfficeId(): ?int
    {
        return $this->commercialOfficeId;
    }

    public function setCommercialOfficeId(?int $commercialOfficeId): void
    {
        $this->commercialOfficeId = $commercialOfficeId;
    }

    public function getProvinceId(): ?int
    {
        return $this->provinceId;
    }

    public function setProvinceId(?int $provinceId): void
    {
        $this->provinceId = $provinceId;
    }

    public function getNationality(): ?int
    {
        return $this->nationality;
    }

    public function setNationality(?int $nationality): void
    {
        $this->nationality = $nationality;
    }
}
