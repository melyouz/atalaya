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

namespace App\Users\Domain\Repository;

use App\Users\Domain\Exception\UserNotFoundException;
use App\Users\Domain\Model\User;
use App\Users\Domain\Model\User\UserConfirmationToken;
use App\Users\Domain\Model\User\UserEmail;
use App\Users\Domain\Model\User\UserId;

interface UserRepositoryInterface
{
    /**
     * @param UserId $id
     * @return User
     * @throws UserNotFoundException
     */
    public function get(UserId $id): User;

    /**
     * @param UserEmail $email
     * @return User
     * @throws UserNotFoundException
     */
    public function getByEmail(UserEmail $email): User;

    /**
     * @param UserConfirmationToken $token
     * @return User
     * @throws UserNotFoundException
     */
    public function getByToken(UserConfirmationToken $token): User;

    /**
     * @param UserEmail $email
     * @return bool
     */
    public function emailExists(UserEmail $email): bool;

    /**
     * @param User $user
     */
    public function save(User $user): void;
}
