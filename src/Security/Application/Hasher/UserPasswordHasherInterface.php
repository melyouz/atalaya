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

namespace App\Security\Application\Hasher;

use App\Users\Domain\Model\User;
use App\Users\Domain\Model\User\UserPlainPassword;

interface UserPasswordHasherInterface
{
    /**
     * @param User $user
     * @param UserPlainPassword $plainPassword
     *
     * @return string
     */
    public function hashPassword(User $user, UserPlainPassword $plainPassword): string;

    /**
     * @param User $user
     * @param UserPlainPassword $plainPassword
     * @return bool
     */
    public function isPasswordValid(User $user, UserPlainPassword $plainPassword): bool;
}
