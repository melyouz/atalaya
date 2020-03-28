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

namespace App\Projects\Domain\Model;

use App\Shared\Domain\Model\AbstractStringValueObject;
use Assert\Assertion;

class ProjectPlatform extends AbstractStringValueObject
{
    const MAX_LENGTH = 30;
    const CHOICES = [
        'PHP',
        'Symfony',
    ];

    public static function fromString(string $value): self
    {
        Assertion::notBlank($value);
        Assertion::maxLength($value, self::MAX_LENGTH);
        Assertion::inArray($value, self::CHOICES);

        return new self($value);
    }
}
