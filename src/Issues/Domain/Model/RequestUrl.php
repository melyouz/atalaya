<?php

declare(strict_types=1);

namespace App\Issues\Domain\Model;

use App\Shared\Domain\Model\AbstractValueObject;
use Assert\Assertion;

class RequestUrl extends AbstractValueObject
{
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromString(string $value): self
    {
        Assertion::notBlank($value);
        Assertion::url($value);
        Assertion::maxLength($value, 255);

        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}
