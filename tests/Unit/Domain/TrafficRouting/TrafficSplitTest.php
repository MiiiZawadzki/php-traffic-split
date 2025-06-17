<?php

namespace Tests\Unit\Domain\TrafficRouting;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Src\Domain\Payment\Payment;
use Src\Domain\Payment\PaymentGatewayInterface;
use Src\Domain\Payment\ValueObject\Money;
use Src\Domain\Payment\ValueObject\PaymentId;
use Src\Domain\TrafficRouting\SplitStrategyInterface;
use Src\Domain\TrafficRouting\TrafficSplit;

#[CoversClass(TrafficSplit::class)]
#[Group('traffic_routing')]
#[Group('unit')]
final class TrafficSplitTest extends TestCase
{
    public function test_splits_payment_to_selected_gateway(): void
    {
        $payment = new Payment(new PaymentId(uniqid()), new Money(10));

        $gateway = $this->createMock(PaymentGatewayInterface::class);
        $gateway->expects($this->once())
            ->method('handle')
            ->with($payment);

        $strategy = $this->createMock(SplitStrategyInterface::class);
        $strategy->method('selectGateway')->willReturn($gateway);

        $router = new TrafficSplit([$gateway], $strategy);
        $router->handlePayment($payment);
    }
}