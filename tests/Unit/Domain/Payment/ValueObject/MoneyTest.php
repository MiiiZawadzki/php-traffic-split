<?php

namespace Tests\Unit\Domain\Payment\ValueObject;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Src\Domain\Payment\ValueObject\Money;

#[CoversClass(Money::class)]
#[Group('payment')]
#[Group('unit')]
final class MoneyTest extends TestCase
{
    public function test_money_equality(): void
    {
        $amount = random_int(1, 100);
        $money = new Money($amount);

        $this->assertEquals($amount, $money->getAmount());
    }

    public function test_money_should_allow_zeros(): void
    {
        $money = new Money(0);

        $this->assertEquals(0, $money->getAmount());
    }

    public function test_money_should_not_allow_negative_amount(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Amount must be greater or equal to 0 and less than 1 000 000');

        new Money(-5);
    }

    public function test_money_should_not_allow_amount_grater_than_max(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Amount must be greater or equal to 0 and less than 1 000 000');

        new Money(1000000);
    }
}