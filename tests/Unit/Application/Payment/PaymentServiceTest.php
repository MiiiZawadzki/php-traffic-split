<?php

namespace Tests\Unit\Application\Payment;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Src\Application\Payment\PaymentService;
use Src\Domain\Payment\PaymentInterface;
use Src\Domain\TrafficRouting\TrafficSplit;

#[CoversClass(PaymentService::class)]
#[Group('payment')]
#[Group('unit')]
final class PaymentServiceTest extends TestCase
{
    public function test_gateway_returns_correct_gateway(): void
    {
        $payment = $this->createMock(PaymentInterface::class);
        $splitter = $this->createMock(TrafficSplit::class);

        $splitter->expects($this->once())
            ->method('handlePayment')
            ->with($payment);

        $service = new PaymentService($splitter);
        $service->process($payment);
    }
}