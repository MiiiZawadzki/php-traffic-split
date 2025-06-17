<?php

namespace Src\Domain\Payment\ValueObject;

final readonly class PaymentId
{
    public function __construct(
        private string $id
    )
    {
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}