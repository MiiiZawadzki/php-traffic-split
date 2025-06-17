<?php

namespace Src\Domain\Payment;

interface PaymentGatewayInterface
{
    /**
     * @return int
     */
    public function getTrafficLoad(): int;

    /**
     * @param PaymentInterface $payment
     * @return void
     */
    public function handle(PaymentInterface $payment): void;
}