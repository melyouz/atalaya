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

namespace App\Users\Application\Command;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Users\Application\Encoder\UserPasswordEncoderInterface;
use App\Users\Domain\Model\UserEncodedPassword;
use App\Users\Domain\Repository\UserRepositoryInterface;

class EditUserCommandHandler implements CommandHandlerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepo;

    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(UserRepositoryInterface $userRepo, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userRepo = $userRepo;
        $this->userPasswordEncoder = $userPasswordEncoder;
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
            $encodedPassword = UserEncodedPassword::fromString($this->userPasswordEncoder->encodePassword($user, $command->getPlainPassword()));

            if (!$user->getPassword()->sameValueAs($encodedPassword)) {
                $user->changePassword($encodedPassword);
            }
        }

        $this->userRepo->save($user);
    }
}
