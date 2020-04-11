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

namespace App\Issues\Domain\Model\Issue\Request;

use App\Shared\Domain\Model\AbstractStringValueObject;
use Assert\Assertion;

class RequestMethod extends AbstractStringValueObject
{
    const AVAILABLE_METHODS = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

    public static function fromString(string $value): self
    {
        Assertion::inArray($value, self::AVAILABLE_METHODS);

        return new self($value);
    }
}
