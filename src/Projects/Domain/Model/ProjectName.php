<?php

declare(strict_types=1);

namespace App\Projects\Domain\Model;

use App\Shared\Domain\Model\AbstractValueObject;
use Assert\Assertion;

final class ProjectName extends AbstractValueObject
{
    const MAX_LENGTH = 80;
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromString(string $value): self
    {
        Assertion::notBlank($value);
        Assertion::maxLength($value, self::MAX_LENGTH);

        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}
