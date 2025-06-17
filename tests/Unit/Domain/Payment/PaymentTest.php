<?php

namespace Tests\Unit\Domain\Payment;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Src\Domain\Payment\Payment;
use Src\Domain\Payment\ValueObject\Money;
use Src\Domain\Payment\ValueObject\PaymentId;

#[CoversClass(Payment::class)]
#[Group('payment')]
#[Group('unit')]
final class PaymentTest extends TestCase
{
    public function test_payment_creation(): void
    {
        $paymentId = new PaymentId(uniqid());
        $amount = new Money(999);

        $payment = new Payment($paymentId, $amount);

        $this->assertEquals($paymentId, $payment->getId());
        $this->assertEquals($amount, $payment->getAmount());
    }
}