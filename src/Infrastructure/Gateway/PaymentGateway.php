<?php

namespace Src\Infrastructure\Gateway;

use InvalidArgumentException;
use Src\Domain\Payment\PaymentGatewayInterface;
use Src\Domain\Payment\PaymentInterface;

class PaymentGateway implements PaymentGatewayInterface
{
    public function __construct(
        private readonly string $name,
        private int             $load = 0
    )
    {
        if ($load < 0) {
            throw new InvalidArgumentException('Traffic load must be greater than 0');
        }
    }

    /**
     * @param PaymentInterface $payment
     * @return void
     */
    public function handle(PaymentInterface $payment): void
    {
        $this->load++;
    }

    /**
     * @return int
     */
    public function getTrafficLoad(): int
    {
        return $this->load;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}