<?php

namespace Src\Domain\TrafficRouting;

use Src\Domain\Payment\PaymentInterface;

readonly class TrafficSplit
{
    public function __construct(
        private array                  $gateways,
        private SplitStrategyInterface $splitter
    )
    {
    }

    /**
     * @param PaymentInterface $payment
     * @return void
     */
    public function handlePayment(PaymentInterface $payment): void
    {
        $gateway = $this->splitter->selectGateway($this->gateways);
        $gateway->handle($payment);
    }
}