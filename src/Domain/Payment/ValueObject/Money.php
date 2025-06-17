<?php

namespace Src\Domain\Payment\ValueObject;

use InvalidArgumentException;

final readonly class Money
{
    public function __construct(
        private int $amount
    )
    {
        if ($amount < 0 || $amount >= 1000000) {
            throw new InvalidArgumentException('Amount must be greater or equal to 0 and less than 1 000 000');
        }
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }
}