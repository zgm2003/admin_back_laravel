<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

final class BusinessException extends RuntimeException
{
    public function __construct(
        string $message,
        private readonly string $codeName = 'BUSINESS_ERROR',
        private readonly int $httpStatus = 400
    ) {
        parent::__construct($message);
    }

    public function codeName(): string
    {
        return $this->codeName;
    }

    public function status(): int
    {
        return $this->httpStatus;
    }
}
