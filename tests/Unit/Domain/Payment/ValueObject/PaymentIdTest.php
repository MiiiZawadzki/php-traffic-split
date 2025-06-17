<?php

namespace Tests\Unit\Domain\Payment\ValueObject;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Src\Domain\Payment\ValueObject\PaymentId;

#[CoversClass(PaymentId::class)]
#[Group('payment')]
#[Group('unit')]
final class PaymentIdTest extends TestCase
{
    public function test_payment_id_equality(): void
    {
        $id = uniqid();
        $paymentIdA = new PaymentId($id);
        $paymentIdB = new PaymentId(uniqid());


        $this->assertEquals($id, $paymentIdA->getId());
        $this->assertNotEquals($id, $paymentIdB->getId());
    }
}