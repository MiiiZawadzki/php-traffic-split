<?php

namespace Src\Domain\Payment;

use Src\Domain\Payment\ValueObject\Money;
use Src\Domain\Payment\ValueObject\PaymentId;

interface PaymentInterface
{
    /**
     * @return PaymentId
     */
    public function getId(): PaymentId;

    /**
     * @return Money
     */
    public function getAmount(): Money;
}