<?php

namespace Src\Domain\TrafficRouting;

use Exception;
use Src\Domain\Payment\PaymentInterface;
use Src\Infrastructure\DependencyInjection\Container;

readonly class TrafficSplit
{
    public function __construct(
        private array $gateways
    )
    {
    }

    /**
     * @param PaymentInterface $payment
     * @return void
     * @throws Exception
     */
    public function handlePayment(PaymentInterface $payment): void
    {
        $container = Container::getInstance();

        /** @var SplitStrategyInterface $splitter */
        $splitter = $container->make(SplitStrategyInterface::class);

        $gateway = $splitter->selectGateway($this->gateways);
        $gateway->handle($payment);
    }
}