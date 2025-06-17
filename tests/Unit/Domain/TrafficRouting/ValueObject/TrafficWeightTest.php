<?php

namespace Tests\Unit\Domain\TrafficRouting\ValueObject;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Src\Domain\TrafficRouting\ValueObject\TrafficWeight;

#[CoversClass(TrafficWeight::class)]
#[Group('traffic_routing')]
#[Group('unit')]
final class TrafficWeightTest extends TestCase
{
    public function test_traffic_weight_equality(): void
    {
        $trafficWeight = new TrafficWeight(75);

        $this->assertEquals(75, $trafficWeight->toInt());
    }

    public function test_traffic_weight_should_allow_zeros(): void
    {
        $trafficWeight = new TrafficWeight(0);

        $this->assertEquals(0, $trafficWeight->toInt());
    }

    public function test_traffic_weight_should_allow_one_hundred(): void
    {
        $trafficWeight = new TrafficWeight(100);

        $this->assertEquals(100, $trafficWeight->toInt());
    }

    public function test_traffic_weight_should_not_allow_values_greater_than_one_hundred(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Percentage must be between 0% and 100%');

        new TrafficWeight(101);
    }
}