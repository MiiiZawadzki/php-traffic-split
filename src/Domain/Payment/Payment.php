<?php

namespace Src\Domain\Payment;

use Src\Domain\Payment\ValueObject\Money;
use Src\Domain\Payment\ValueObject\PaymentId;

final readonly class Payment implements PaymentInterface
{
    public function __construct(
        private PaymentId $id,
        private Money     $amount
    )
    {
    }

    /**
     * @return PaymentId
     */
    public function getId(): PaymentId
    {
        return $this->id;
    }

    /**
     * @return Money
     */
    public function getAmount(): Money
    {
        return $this->amount;
    }
}