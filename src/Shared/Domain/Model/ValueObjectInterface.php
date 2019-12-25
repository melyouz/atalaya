<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model;

interface  ValueObjectInterface
{
    public static function fromString(string $value): ValueObjectInterface;

    public function sameValueAs(ValueObjectInterface $other): bool;

    public function value(): string;

    public function __toString(): string;
}