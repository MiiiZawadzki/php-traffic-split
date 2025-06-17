<?php

namespace Tests\Unit\Domain\TrafficRouting;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Src\Domain\Payment\PaymentGatewayInterface;
use Src\Domain\Payment\PaymentInterface;
use Src\Domain\TrafficRouting\SplitStrategyInterface;
use Src\Domain\TrafficRouting\TrafficSplit;
use Src\Infrastructure\DependencyInjection\Container;

#[CoversClass(TrafficSplit::class)]
#[Group('traffic_routing')]
#[Group('unit')]
final class TrafficSplitTest extends TestCase
{
    public function test_splits_payment_to_selected_gateway(): void
    {
        $payment = $this->createMock(PaymentInterface::class);

        $gateway = $this->createMock(PaymentGatewayInterface::class);
        $gateway->expects($this->once())
            ->method('handle')
            ->with($payment);

        $strategy = $this->createMock(SplitStrategyInterface::class);
        $strategy->method('selectGateway')->willReturn($gateway);

        $container = Container::getInstance();
        $container->bind(SplitStrategyInterface::class, fn() => $strategy);

        $router = new TrafficSplit([$gateway]);
        $router->handlePayment($payment);
    }
}