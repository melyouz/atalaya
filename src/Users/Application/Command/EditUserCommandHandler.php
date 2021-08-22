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

namespace App\Users\Application\Command;

use App\Security\Application\Hasher\UserPasswordHasherInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Users\Domain\Model\User\UserHashedPassword;
use App\Users\Domain\Repository\UserRepositoryInterface;

class EditUserCommandHandler implements CommandHandlerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepo;

    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserRepositoryInterface $userRepo, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userRepo = $userRepo;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function __invoke(EditUserCommand $command): void
    {
        $user = $this->userRepo->get($command->getId());

        if ($command->getName() && !$user->getName()->sameValueAs($command->getName())) {
            $user->changeName($command->getName());
        }

        if ($command->getEmail() && !$user->getEmail()->sameValueAs($command->getEmail())) {
            $user->changeEmail($command->getEmail());
        }

        if ($command->getPlainPassword()) {
            $encodedPassword = UserHashedPassword::fromString($this->userPasswordHasher->hashPassword($user, $command->getPlainPassword()));

            if ($user->getPassword() != $encodedPassword) {
                $user->changePassword($encodedPassword);
            }
        }

        $this->userRepo->save($user);
    }
}
