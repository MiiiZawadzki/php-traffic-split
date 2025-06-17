<?php

namespace Src\Domain\TrafficRouting\Strategy;

use PHPUnit\Framework\Exception;
use Src\Domain\Payment\PaymentGatewayInterface;
use Src\Domain\TrafficRouting\SplitStrategyInterface;
use Src\Domain\TrafficRouting\WeightedGateway;

final class WeightedStrategy implements SplitStrategyInterface
{
    /**
     * @param array $gateways
     * @return PaymentGatewayInterface
     */
    public function selectGateway(array $gateways): PaymentGatewayInterface
    {
        $totalWeight = array_sum(
            array_map(
                fn(WeightedGateway $gateway) => $gateway->getWeight()->toInt(),
                $gateways
            )
        );
        $rand = rand(1, $totalWeight);
        $cumulative = 0;

        foreach ($gateways as $gateway) {
            $cumulative += $gateway->getWeight()->toInt();
            if ($rand <= $cumulative) {
                return $gateway->getGateway();
            }
        }

        throw new Exception(self::class . " Algorithm error");
    }
}