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

namespace Tests\Users\Application\Command;

use App\Security\Application\Hasher\UserPasswordHasherInterface;
use App\Shared\Application\Util\TokenGenerator;
use App\Users\Application\Command\RegisterUserCommand;
use App\Users\Application\Command\RegisterUserCommandHandler;
use App\Users\Domain\Exception\EmailTakenException;
use App\Users\Domain\Model\User;
use App\Users\Domain\Model\User\UserConfirmationToken;
use App\Users\Domain\Model\User\UserEmail;
use App\Users\Domain\Model\User\UserHashedPassword;
use App\Users\Domain\Model\User\UserId;
use App\Users\Domain\Model\User\UserName;
use App\Users\Domain\Repository\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

class RegisterUserCommandHandlerTest extends TestCase
{
    public function testRegisterUser()
    {
        $id = '3c9ec32a-9c3a-4be1-b64d-0a0bb6ddf28f';
        $name = 'John Doe';
        $email = 'johndoe@awesome-project.dev';
        $plainPassword = 'WhateverPlainPassword';
        $encodedPassword = 'WhateverEncodedPassword';
        $userWithoutPassword = new User(UserId::fromString($id), UserName::fromString($name), UserEmail::fromString($email), UserConfirmationToken::fromString('someRandomToken'));

        $command = new RegisterUserCommand($id, $name, $email, $plainPassword);

        $userPasswordEncoderMock = $this->createMock(UserPasswordHasherInterface::class);
        $userPasswordEncoderMock->expects($this->once())
            ->method('hashPassword')
            ->with($userWithoutPassword, $plainPassword)
            ->willReturn($encodedPassword);

        $userWithPassword = clone $userWithoutPassword;
        $userWithPassword->setPassword(UserHashedPassword::fromString($encodedPassword));
        $repoMock = $this->createMock(UserRepositoryInterface::class);
        $repoMock->expects($this->once())
            ->method('save')
            ->with($userWithPassword);

        $repoMock->expects($this->once())
            ->method('emailExists')
            ->with(UserEmail::fromString($email))
            ->willReturn(false);

        $tokenGeneratorMock = $this->createMock(TokenGenerator::class);
        $tokenGeneratorMock->expects($this->once())
            ->method('randomToken')
            ->willReturn('someRandomToken');

        $handler = new RegisterUserCommandHandler($repoMock, $userPasswordEncoderMock, $tokenGeneratorMock);
        $handler->__invoke($command);
    }

    public function testRegisterUserWithTakenEmail(): void
    {
        $this->expectException(EmailTakenException::class);

        $id = '3c9ec32a-9c3a-4be1-b64d-0a0bb6ddf28f';
        $name = 'John Doe';
        $email = 'johndoe@awesome-project.dev';
        $plainPassword = 'WhateverPlainPassword';
        $encodedPassword = 'WhateverEncodedPassword';
        $userWithoutPassword = new User(UserId::fromString($id), UserName::fromString($name), UserEmail::fromString($email), UserConfirmationToken::fromString('someRandomToken'));

        $command = new RegisterUserCommand($id, $name, $email, $plainPassword);
        $repoMock = $this->createMock(UserRepositoryInterface::class);

        $repoMock->expects($this->once())
            ->method('emailExists')
            ->with(UserEmail::fromString($email))
            ->willReturn(true);

        $userPasswordEncoderMock = $this->createMock(UserPasswordHasherInterface::class);
        $tokenGeneratorMock = $this->createMock(TokenGenerator::class);

        $handler = new RegisterUserCommandHandler($repoMock, $userPasswordEncoderMock, $tokenGeneratorMock);
        $handler->__invoke($command);
    }
}
