<?php
/**
 *
 * @copyright 2019 Mohammadi El Youzghi. All rights reserved
 * @author    Mohammadi El Youzghi (mo.elyouzghi@gmail.com)
 *
 * @link      https://github.com/ayrad
 *
 * @licence   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

declare(strict_types=1);

namespace App\Shared\Domain\Model;

use JsonSerializable;

abstract class AbstractIntegerValueObject implements ValueObjectInterface, JsonSerializable
{
    protected int $value;

    protected function __construct(int $value)
    {
        $this->value = $value;
    }

    public abstract static function fromInteger(int $value): self;

    public function sameValueAs(ValueObjectInterface $other): bool
    {
        return $this->value() === $other->value();
    }

    public function value(): int
    {
        return $this->value;
    }

    public function jsonSerialize(): string
    {
        return $this->__toString();
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }
}
