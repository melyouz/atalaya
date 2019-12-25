<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model;

use Assert\Assertion;

abstract class Uuid extends AbstractValueObject
{
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromString(string $value): self
    {
        Assertion::notBlank($value);
        Assertion::uuid($value);

        return new static($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}
