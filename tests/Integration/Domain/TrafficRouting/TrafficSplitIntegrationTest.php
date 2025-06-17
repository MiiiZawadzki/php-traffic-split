<?php

namespace Integration\Domain\TrafficRouting;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Src\Domain\Payment\Payment;
use Src\Domain\Payment\ValueObject\Money;
use Src\Domain\Payment\ValueObject\PaymentId;
use Src\Domain\TrafficRouting\SplitStrategyInterface;
use Src\Domain\TrafficRouting\Strategy\LeastLoadedStrategy;
use Src\Domain\TrafficRouting\Strategy\WeightedStrategy;
use Src\Domain\TrafficRouting\TrafficSplit;
use Src\Domain\TrafficRouting\ValueObject\TrafficWeight;
use Src\Domain\TrafficRouting\WeightedGateway;
use Src\Infrastructure\DependencyInjection\Container;
use Src\Infrastructure\Gateway\PaymentGateway;

#[CoversClass(TrafficSplit::class)]
#[Group('traffic_routing')]
#[Group('integration')]
final class TrafficSplitIntegrationTest extends TestCase
{
    public function test_splits_payment_to_gateways_in_weighted_strategy(): void
    {
        $gatewayA = new PaymentGateway('Gateway A');
        $gatewayB = new PaymentGateway('Gateway B');
        $gatewayC = new PaymentGateway('Gateway C');

        $gateways = [
            new WeightedGateway($gatewayA, new TrafficWeight(60)),
            new WeightedGateway($gatewayB, new TrafficWeight(30)),
            new WeightedGateway($gatewayC, new TrafficWeight(10)),
        ];

        $container = Container::getInstance();
        $container->bind(SplitStrategyInterface::class, fn() => new WeightedStrategy());

        $splitter = new TrafficSplit($gateways);

        for ($i = 0; $i < 100; $i++) {
            $splitter->handlePayment(
                new Payment(new PaymentId(uniqid()), new Money(10))
            );
        }

        $paymentSum = array_reduce(
            $gateways,
            fn(int $trafficLoad, WeightedGateway $gateway) => $trafficLoad += $gateway->getGateway()->getTrafficLoad()
            ,
            0
        );

        $this->assertEquals(100, $paymentSum);

        $this->assertGreaterThan($gatewayB->getTrafficLoad(), $gatewayA->getTrafficLoad());
        $this->assertGreaterThan($gatewayC->getTrafficLoad(), $gatewayA->getTrafficLoad());
    }

    public function test_splits_payment_to_gateways_in_least_loaded_strategy(): void
    {
        $gatewayA = new PaymentGateway('Gateway A', 100);
        $gatewayB = new PaymentGateway('Gateway B');
        $gatewayC = new PaymentGateway('Gateway C');

        $gateways = [
            $gatewayA,
            $gatewayB,
            $gatewayC
        ];

        $container = Container::getInstance();
        $container->bind(SplitStrategyInterface::class, fn() => new LeastLoadedStrategy());

        $splitter = new TrafficSplit($gateways);

        for ($i = 0; $i < 100; $i++) {
            $splitter->handlePayment(
                new Payment(new PaymentId(uniqid()), new Money(10))
            );
        }

        $paymentSum = array_reduce(
            $gateways,
            fn(int $trafficLoad, PaymentGateway $gateway) => $trafficLoad += $gateway->getTrafficLoad()
            ,
            0
        );

        $this->assertEquals(200, $paymentSum);
        $this->assertEquals(100, $gatewayA->getTrafficLoad());
        $this->assertEquals(50, $gatewayB->getTrafficLoad());
        $this->assertEquals(50, $gatewayC->getTrafficLoad());
    }
}