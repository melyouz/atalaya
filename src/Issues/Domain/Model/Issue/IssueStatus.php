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

namespace App\Issues\Domain\Model\Issue;

use App\Shared\Domain\Model\AbstractStringValueObject;
use Assert\Assertion;

class IssueStatus extends AbstractStringValueObject
{
    const DRAFT = 'Draft';
    const OPEN = 'Open';
    const RESOLVED = 'Resolved';
    const VALUES = [self::DRAFT, self::OPEN, self::RESOLVED];

    public static function fromString(string $value): self
    {
        Assertion::inArray($value, self::VALUES);

        return new self($value);
    }
}
