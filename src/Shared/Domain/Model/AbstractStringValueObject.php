<?php
/*
 *
 * @copyright 2019-present Mohammadi El Youzghi. All rights reserved
 * @author    Mohammadi El Youzghi (mo.elyouzghi@gmail.com)
 *
 * @link      https://github.com/melyouz
 *
 * @licence   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

declare(strict_types=1);

namespace App\Shared\Domain\Model;

use JsonSerializable;

abstract class AbstractStringValueObject implements ValueObjectInterface, JsonSerializable
{
    public const MAX_LENGTH = 255;

    protected string $value;

    protected function __construct(string $value)
    {
        $this->value = $value;
    }

    abstract public static function fromString(string $value): self;

    public function sameValueAs(ValueObjectInterface $other): bool
    {
        return $this->value() === $other->value();
    }

    public function value(): string
    {
        return $this->value;
    }

    public function jsonSerialize(): string
    {
        return $this->__toString();
    }

    public function __toString(): string
    {
        return $this->value();
    }
}
