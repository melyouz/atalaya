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

namespace App\Security\Application;

use App\Security\Domain\Exception\UserNotLoggedInException;
use App\Users\Domain\Model\User;

interface AuthServiceInterface
{
    /**
     * @throws UserNotLoggedInException
     */
    public function getLoggedInUser(): User;

    /**
     * @param $attributes
     * @param $subject
     */
    public function isGranted($attributes, $subject): bool;
}
