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

namespace App\Users\Domain\Model\User;

use App\Shared\Domain\Model\AbstractStringValueObject;
use Assert\Assertion;

class UserEmail extends AbstractStringValueObject
{
    public static function fromString(string $value): self
    {
        Assertion::notBlank($value);
        Assertion::email($value);
        Assertion::maxLength($value, self::MAX_LENGTH);

        return new self($value);
    }
}
