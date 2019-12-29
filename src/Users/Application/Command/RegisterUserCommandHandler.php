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
use App\Users\Domain\Model\User;
use App\Users\Domain\Model\UserEncodedPassword;
use App\Users\Domain\Repository\UserRepositoryInterface;

class RegisterUserCommandHandler implements CommandHandlerInterface
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

    public function __invoke(RegisterUserCommand $command)
    {
        $user = User::register($command->getId(), $command->getName(), $command->getEmail());
        $encodedPassword = $this->userPasswordEncoder->encodePassword($user, $command->getPlainPassword());
        $user->setPassword(UserEncodedPassword::fromString($encodedPassword));

        $this->userRepo->save($user);
    }
}
