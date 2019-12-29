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

namespace App\Users\Domain\Repository;

use App\Projects\Domain\Exception\ProjectNotFoundException;
use App\Projects\Domain\Model\Project;
use App\Projects\Domain\Model\ProjectId;
use App\Users\Domain\Exception\UserNotFoundException;
use App\Users\Domain\Model\User;
use App\Users\Domain\Model\UserEmail;
use App\Users\Domain\Model\UserId;

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
     * @param User $user
     */
    public function save(User $user): void;
}
