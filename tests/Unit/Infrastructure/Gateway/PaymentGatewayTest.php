<?php

namespace Tests\Unit\Infrastructure\Gateway;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Src\Domain\Payment\PaymentInterface;
use Src\Infrastructure\Gateway\PaymentGateway;

#[CoversClass(PaymentGateway::class)]
#[Group('payment')]
#[Group('gateway')]
#[Group('unit')]
final class PaymentGatewayTest extends TestCase
{
    public function test_payment_gateway_creation(): void
    {
        $name = "Payment Gateway 1";
        $load = 15;

        $paymentGateway = new PaymentGateway($name, $load);

        $this->assertEquals($name, $paymentGateway->getName());
        $this->assertEquals($load, $paymentGateway->getTrafficLoad());
    }

    public function test_payment_gateway_creation_with_default_load(): void
    {
        $name = "Payment Gateway 2";

        $paymentGateway = new PaymentGateway($name);

        $this->assertEquals($name, $paymentGateway->getName());
        $this->assertEquals(0, $paymentGateway->getTrafficLoad());
    }

    public function test_payment_gateway_should_not_allow_negative_load(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Traffic load must be greater than 0');

        new PaymentGateway("Test Gateway", -10);
    }

    public function test_payment_gateway_should_increment_load(): void
    {
        $payment = $this->createMock(PaymentInterface::class);
        $paymentGateway = new PaymentGateway("Test Gateway");

        $this->assertEquals(0, $paymentGateway->getTrafficLoad());

        $paymentGateway->handle($payment);

        $this->assertEquals(1, $paymentGateway->getTrafficLoad());

    }
}