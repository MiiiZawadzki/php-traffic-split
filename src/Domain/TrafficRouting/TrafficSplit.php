<?php

namespace Src\Domain\TrafficRouting;

use Src\Domain\Payment\Payment;

final class TrafficSplit
{
    public function __construct(
        private array                  $gateways,
        private SplitStrategyInterface $splitter
    )
    {
    }

    /**
     * @param Payment $payment
     * @return void
     */
    public function handlePayment(Payment $payment): void
    {
        $gateway = $this->splitter->selectGateway($this->gateways);
        $gateway->handle($payment);
    }
}