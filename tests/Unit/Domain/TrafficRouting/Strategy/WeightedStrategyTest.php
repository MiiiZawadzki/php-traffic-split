<?php

namespace Tests\Unit\Domain\TrafficRouting\Strategy;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Src\Domain\Payment\PaymentGatewayInterface;
use Src\Domain\TrafficRouting\Strategy\WeightedStrategy;
use Src\Domain\TrafficRouting\ValueObject\TrafficWeight;
use Src\Domain\TrafficRouting\WeightedGateway;

#[CoversClass(WeightedStrategy::class)]
#[Group('strategy')]
#[Group('traffic_routing')]
#[Group('unit')]
final class WeightedStrategyTest extends TestCase
{
    public function test_strategy_selects_gateway_based_on_weights(): void
    {
        $paymentGatewayA = $this->createMock(PaymentGatewayInterface::class);
        $paymentGatewayB = $this->createMock(PaymentGatewayInterface::class);

        $weightedGateways = [
            new WeightedGateway($paymentGatewayA, new TrafficWeight(90)),
            new WeightedGateway($paymentGatewayB, new TrafficWeight(10)),
        ];

        $splitStrategy = new WeightedStrategy();

        $selectedA = 0;
        $selectedB = 0;

        for ($i = 0; $i < 1000; $i++) {
            $selected = $splitStrategy->selectGateway($weightedGateways);
            if ($selected === $paymentGatewayA) {
                $selectedA++;
            } else {
                $selectedB++;
            }
        }

        $this->assertGreaterThan($selectedB, $selectedA);
    }
}