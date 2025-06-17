<?php

namespace Tests\Unit\Domain\TrafficRouting\Strategy;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Src\Domain\Payment\PaymentGatewayInterface;
use Src\Domain\TrafficRouting\Strategy\LeastLoadedStrategy;

#[CoversClass(LeastLoadedStrategy::class)]
#[Group('strategy')]
#[Group('traffic_routing')]
#[Group('unit')]
final class LeastLoadedStrategyTest extends TestCase
{
    public function test_strategy_selects_gateway_based_on_load(): void
    {
        $paymentGatewayA = $this->createMock(PaymentGatewayInterface::class);
        $paymentGatewayA->expects($this->exactly(5))
            ->method('getTrafficLoad')
            ->willReturn(25);

        $paymentGatewayB = $this->createMock(PaymentGatewayInterface::class);
        $paymentGatewayB->expects($this->exactly(5))
            ->method('getTrafficLoad')
            ->willReturn(50);

        $splitter = new LeastLoadedStrategy();

        $selectedA = 0;
        $selectedB = 0;

        for ($i = 0; $i < 5; $i++) {
            $selected = $splitter->selectGateway([$paymentGatewayA, $paymentGatewayB]);
            if ($selected === $paymentGatewayA) {
                $selectedA++;
            } else {
                $selectedB++;
            }
        }

        $this->assertEquals(5, $selectedA);
        $this->assertEquals(0, $selectedB);
    }
}