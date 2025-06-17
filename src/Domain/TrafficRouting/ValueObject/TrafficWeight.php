<?php

namespace Src\Domain\TrafficRouting\ValueObject;

use InvalidArgumentException;

final readonly class TrafficWeight
{
    public function __construct(private int $percentage)
    {
        if ($percentage < 0 || $percentage > 100) {
            throw new InvalidArgumentException('Percentage must be between 0% and 100%');
        }
    }

    public function toInt(): int
    {
        return $this->percentage;
    }

    public function toFloat(): float
    {
        return $this->percentage / 100.0;
    }
}