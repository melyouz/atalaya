<?php
/**
 *
 * @copyright 2020 Mohammadi El Youzghi. All rights reserved
 * @author    Mohammadi El Youzghi (mo.elyouzghi@gmail.com)
 *
 * @link      https://github.com/ayrad
 *
 * @licence   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

declare(strict_types=1);

namespace App\Projects\Domain\Model\Project;

use App\Shared\Domain\Model\AbstractStringValueObject;
use Assert\Assertion;

class ProjectToken extends AbstractStringValueObject
{
    const MAX_LENGTH = 32;

    public static function fromString(string $value): self
    {
        Assertion::notBlank($value);
        Assertion::length($value, self::MAX_LENGTH);

        return new self($value);
    }
}
