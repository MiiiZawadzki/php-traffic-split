<?php

namespace Src\Domain\TrafficRouting;

use Src\Domain\Payment\PaymentGatewayInterface;
use Src\Domain\TrafficRouting\ValueObject\TrafficWeight;

final readonly class WeightedGateway
{
    public function __construct(
        private PaymentGatewayInterface $gateway,
        private TrafficWeight           $weight
    )
    {
    }

    /**
     * @return PaymentGatewayInterface
     */
    public function getGateway(): PaymentGatewayInterface
    {
        return $this->gateway;
    }

    /**
     * @return TrafficWeight
     */
    public function getWeight(): TrafficWeight
    {
        return $this->weight;
    }
}