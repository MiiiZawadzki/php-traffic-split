<?php

namespace Tests\Unit\Infrastructure\DependencyInjection;

use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Src\Domain\Payment\PaymentGatewayInterface;
use Src\Infrastructure\DependencyInjection\Container;

#[CoversClass(Container::class)]
#[Group('dependency_injection')]
#[Group('unit')]
final class ContainerTest extends TestCase
{
    public function test_container_returns_same_instance(): void
    {
        $containerA = Container::getInstance();
        $containerB = Container::getInstance();

        $this->assertSame($containerA, $containerB);
    }

    public function test_container_binds_and_makes_services(): void
    {
        $container = Container::getInstance();

        $service = $this->createMock(PaymentGatewayInterface::class);

        $container->bind(PaymentGatewayInterface::class, fn() => $service);

        $resultService = $container->make(PaymentGatewayInterface::class);

        $this->assertInstanceOf(PaymentGatewayInterface::class, $resultService);
        $this->assertSame($service, $resultService);
    }

    public function test_container_throw_exception_on_missing_binding(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('No binding found for FakeService');

        $container = Container::getInstance();
        $container->make('FakeService');
    }
}