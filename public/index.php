<?php

use Src\Application\Payment\PaymentService;
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

require __DIR__ . '/../vendor/autoload.php';

$results = [];

function initSimulation(SplitStrategyInterface $strategy, array $gateways, string $name, array &$results): void
{
    // DI set up
    $container = Container::getInstance();
    $container->bind(SplitStrategyInterface::class, fn() => $strategy);

    $splitter = new TrafficSplit($gateways);

    $service = new PaymentService($splitter);

    for ($i = 0; $i < 100; $i++) {
        $payment = new Payment(
            new PaymentId(uniqid()),
            new Money(10)
        );
        $service->process($payment);
    }

    $results[$name] = array_map(
        function ($gateway) {
            $newGateway = $gateway;
            if ($gateway instanceof WeightedGateway) {
                $newGateway = $gateway->getGateway();
            }
            return [
                'name' => $newGateway->getName(),
                'count' => $newGateway->getTrafficLoad(),
                'percent' => $newGateway->getTrafficLoad() . "%"
            ];
        },
        $gateways
    );
}

initSimulation(
    new WeightedStrategy(),
    [
        new WeightedGateway(new PaymentGateway('Gateway 1'), new TrafficWeight(25)),
        new WeightedGateway(new PaymentGateway('Gateway 2'), new TrafficWeight(25)),
        new WeightedGateway(new PaymentGateway('Gateway 3'), new TrafficWeight(25)),
        new WeightedGateway(new PaymentGateway('Gateway 4'), new TrafficWeight(25)),
    ],
    "Weighted Traffic Strategy (25%, 25%, 25%, 25%)",
    $results
);

initSimulation(
    new WeightedStrategy(),
    [
        new WeightedGateway(new PaymentGateway('Gateway 1'), new TrafficWeight(75)),
        new WeightedGateway(new PaymentGateway('Gateway 2'), new TrafficWeight(10)),
        new WeightedGateway(new PaymentGateway('Gateway 3'), new TrafficWeight(15)),
    ],
    "Weighted Traffic Strategy (75%, 10%, 15%)",
    $results
);

initSimulation(
    new LeastLoadedStrategy(),
    [
        new PaymentGateway('Gateway 1', 50),
        new PaymentGateway('Gateway 2'),
        new PaymentGateway('Gateway 3'),
        new PaymentGateway('Gateway 4'),
    ],
    "Least Loaded Traffic Strategy (Gateway 1 is max loaded)",
    $results
);

include __DIR__ . '/../src/UI/Http/Views/index.php';
