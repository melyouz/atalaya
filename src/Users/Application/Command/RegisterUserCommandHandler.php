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
use App\Shared\Application\Util\TokenGenerator;
use App\Users\Domain\Exception\EmailTakenException;
use App\Users\Domain\Model\User;
use App\Users\Domain\Model\User\UserConfirmationToken;
use App\Users\Domain\Model\User\UserHashedPassword;
use App\Users\Domain\Repository\UserRepositoryInterface;

class RegisterUserCommandHandler implements CommandHandlerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepo;

    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $userPasswordHasher;

    /**
     * @var TokenGenerator
     */
    private TokenGenerator $tokenGenerator;

    public function __construct(UserRepositoryInterface $userRepo, UserPasswordHasherInterface $userPasswordHasher, TokenGenerator $tokenGenerator)
    {
        $this->userRepo = $userRepo;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function __invoke(RegisterUserCommand $command): void
    {
        if ($this->userRepo->emailExists($command->getEmail())) {
            throw new EmailTakenException();
        }

        $confirmationToken = UserConfirmationToken::fromString($this->tokenGenerator->randomToken());
        $user = new User($command->getId(), $command->getName(), $command->getEmail(), $confirmationToken);
        $encodedPassword = $this->userPasswordHasher->hashPassword($user, $command->getPlainPassword());
        $user->setPassword(UserHashedPassword::fromString($encodedPassword));

        $this->userRepo->save($user);
    }
}
