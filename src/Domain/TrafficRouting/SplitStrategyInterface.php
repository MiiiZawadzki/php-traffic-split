<?php

namespace Src\Domain\TrafficRouting;

use Src\Domain\Payment\PaymentGatewayInterface;

interface SplitStrategyInterface
{
    /**
     * @param array $gateways
     * @return PaymentGatewayInterface
     */
    public function selectGateway(array $gateways): PaymentGatewayInterface;
}