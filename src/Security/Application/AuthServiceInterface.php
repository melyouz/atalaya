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

namespace App\Security\Application;

use App\Security\Domain\UserNotLoggedInException;
use App\Users\Domain\Model\User;

interface AuthServiceInterface
{
    /**
     * @return User
     * @throws UserNotLoggedInException
     */
    public function getLoggedInUser(): User;

    /**
     * @param $attributes
     * @param $subject
     *
     * @return bool
     */
    public function isGranted($attributes, $subject): bool;
}
