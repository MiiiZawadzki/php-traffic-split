<?php

namespace Tests\Unit\Domain\TrafficRouting;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Src\Domain\Payment\PaymentGatewayInterface;
use Src\Domain\TrafficRouting\ValueObject\TrafficWeight;
use Src\Domain\TrafficRouting\WeightedGateway;

#[CoversClass(WeightedGateway::class)]
#[Group('traffic_routing')]
#[Group('unit')]
final class WeightedGatewayTest extends TestCase
{
    public function test_gateway_returns_correct_gateway(): void
    {
        $gateway = $this->createMock(PaymentGatewayInterface::class);
        $weightedGateway = new WeightedGateway($gateway, new TrafficWeight(10));

        $this->assertSame($gateway, $weightedGateway->getGateway());
    }

    public function test_gateway_returns_correct_weight(): void
    {
        $weight = random_int(1, 100);
        $gateway = $this->createMock(PaymentGatewayInterface::class);
        $weightedGateway = new WeightedGateway($gateway, new TrafficWeight($weight));

        $this->assertEquals($weight, $weightedGateway->getWeight()->toInt());
    }
}