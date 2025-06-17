<?php

namespace Src\Domain\Payment;

interface PaymentGatewayInterface
{
    /**
     * @return int
     */
    public function getTrafficLoad(): int;

    /**
     * @param Payment $payment
     * @return void
     */
    public function handle(Payment $payment): void;
}