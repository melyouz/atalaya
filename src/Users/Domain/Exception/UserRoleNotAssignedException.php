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

namespace App\Users\Domain\Exception;

use Exception;

class UserRoleNotAssignedException extends Exception
{
    public static function fromRole(string $role)
    {
        return new self(sprintf('Role "%s" not assigned to the user.', $role));
    }
}
