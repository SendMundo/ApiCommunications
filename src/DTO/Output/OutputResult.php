<?php

namespace App\DTO\Output;

class OutputResult
{
    private ?int $orderId;
    private ?OutResult $result;
    private ?GetSaleInfo $sale = null;
    private ?object $fullResponse = null;

    /**
     * @param int|null $orderId
     * @param OutResult|null $result
     */
    public function __construct(int $orderId = null, OutResult $result = null)
    {
        $this->orderId = $orderId;
        $this->result = $result;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function getResult(): OutResult
    {
        return $this->result;
    }

    public function setResult(OutResult $result): void
    {
        $this->result = $result;
    }

    public function getSale(): ?GetSaleInfo
    {
        return $this->sale;
    }

    public function setSale(?GetSaleInfo $sale): void
    {
        $this->sale = $sale;
    }

    public function getFullResponse(): ?object
    {
        return $this->fullResponse;
    }

    public function setFullResponse(?object $fullResponse): void
    {
        $this->fullResponse = $fullResponse;
    }
}
