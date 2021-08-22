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

namespace App\Security\Infrastructure\Provider;

use App\Users\Domain\Exception\UserNotFoundException;
use App\Users\Domain\Model\User;
use App\Users\Domain\Model\User\UserEmail;
use App\Users\Domain\Model\User\UserId;
use App\Users\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class SymfonyUserProvider implements UserProviderInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * @inheritDoc
     */
    public function loadUserByUsername(string $username)
    {
        return $this->loadUserByIdentifier($username);
    }

    /**
     * @inheritDoc
     */
    public function loadUserByIdentifier(string $identifier)
    {
        return $this->userRepo->getByEmail(UserEmail::fromString($identifier));
    }

    /**
     * @param string $id
     * @return User
     * @throws UserNotFoundException
     */
    public function loadUserById(string $id)
    {
        return $this->userRepo->get(UserId::fromString($id));
    }

    /**
     * @inheritDoc
     */
    public function refreshUser(UserInterface $user)
    {
        return $this->userRepo->get($user->getId());
    }

    /**
     * @inheritDoc
     */
    public function supportsClass(string $class)
    {
        return User::class === $class;
    }
}
