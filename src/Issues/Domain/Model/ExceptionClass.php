<?php

declare(strict_types=1);

namespace App\Issues\Domain\Model;

use App\Shared\Domain\Model\ValueObjectInterface;
use Assert\Assertion;

class ExceptionClass implements ValueObjectInterface
{
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromString(string $value): self
    {
        Assertion::notBlank($value);

        return new self($value);
    }

    public function sameValueAs(ValueObjectInterface $other): bool
    {
        return $this->value() === $other->value();
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }
}
