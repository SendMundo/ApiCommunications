<?php

namespace App\DTO\Output;

use DateTime;

class OutResult
{
    private bool $valueOk;
    private string $message;
    private DateTime $requestTime;
    private DateTime $responseTime;

    /**
     * @param bool $valueOk
     * @param string $message
     * @param string $requestTime
     * @param string $responseTime
     */
    public function __construct(bool $valueOk, string $message, string $requestTime, string $responseTime)
    {
        $this->valueOk = $valueOk;
        $this->message = $message;
        $this->requestTime = new DateTime($requestTime);
        $this->responseTime = new DateTime($requestTime);
    }

    public function isValueOk(): bool
    {
        return $this->valueOk;
    }

    public function setValueOk(bool $valueOk): void
    {
        $this->valueOk = $valueOk;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getRequestTime(): DateTime
    {
        return $this->requestTime;
    }

    public function setRequestTime(DateTime $requestTime): void
    {
        $this->requestTime = $requestTime;
    }

    public function getResponseTime(): DateTime
    {
        return $this->responseTime;
    }

    public function setResponseTime(DateTime $responseTime): void
    {
        $this->responseTime = $responseTime;
    }
}
