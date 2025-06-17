<?php

namespace Src\Domain\TrafficRouting\Strategy;

use Src\Domain\Payment\PaymentGatewayInterface;
use Src\Domain\TrafficRouting\SplitStrategyInterface;

final class LeastLoadedStrategy implements SplitStrategyInterface
{
    /**
     * @param array $gateways
     * @return PaymentGatewayInterface
     */
    public function selectGateway(array $gateways): PaymentGatewayInterface
    {
        usort($gateways, fn(PaymentGatewayInterface $a, PaymentGatewayInterface $b) =>
            $a->getTrafficLoad() <=> $b->getTrafficLoad()
        );

        return $gateways[0];
    }
}