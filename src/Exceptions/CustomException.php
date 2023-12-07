<?php

namespace App\Exceptions;

use Throwable;

class CustomException extends \RuntimeException
{
    private ?object $customData;

    public function __construct($message = "", $code = 422, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getCustomData(): object|null
    {
        return $this->customData;
    }

    public function setCustomData(?object $customData): void
    {
        $this->customData = $customData;
    }
}
