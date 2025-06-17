<?php

namespace Src\Application\Payment;

use Src\Domain\Payment\PaymentInterface;
use Src\Domain\TrafficRouting\TrafficSplit;

final readonly class PaymentService
{
    public function __construct(private TrafficSplit $splitter)
    {
    }

    /**
     * @param PaymentInterface $payment
     * @return void
     */
    public function process(PaymentInterface $payment): void
    {
        $this->splitter->handlePayment($payment);
    }
}