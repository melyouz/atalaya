<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model;

abstract class AbstractValueObject implements ValueObjectInterface
{
    public function sameValueAs(ValueObjectInterface $other): bool
    {
        return $this->value() === $other->value();
    }

    public function __toString(): string
    {
        return $this->value();
    }
}