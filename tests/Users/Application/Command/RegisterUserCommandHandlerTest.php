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

namespace Tests\Projects\Application\Command;

use App\Users\Application\Command\RegisterUserCommand;
use App\Users\Application\Command\RegisterUserCommandHandler;
use App\Users\Application\Encoder\UserPasswordEncoderInterface;
use App\Users\Domain\Model\User;
use App\Users\Domain\Model\UserEmail;
use App\Users\Domain\Model\UserEncodedPassword;
use App\Users\Domain\Model\UserId;
use App\Users\Domain\Model\UserName;
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
        $userWithoutPassword = User::register(UserId::fromString($id), UserName::fromString($name), UserEmail::fromString($email));

        $command = new RegisterUserCommand($id, $name, $email, $plainPassword);

        $userPasswordEncoderMock = $this->createMock(UserPasswordEncoderInterface::class);
        $userPasswordEncoderMock->expects($this->once())
            ->method('encodePassword')
            ->with($userWithoutPassword, $plainPassword)
            ->willReturn($encodedPassword);

        $userWithPassword = clone $userWithoutPassword;
        $userWithPassword->setPassword(UserEncodedPassword::fromString($encodedPassword));
        $repoMock = $this->createMock(UserRepositoryInterface::class);
        $repoMock->expects($this->once())
            ->method('save')
            ->with($userWithPassword);

        $handler = new RegisterUserCommandHandler($repoMock, $userPasswordEncoderMock);
        $handler->__invoke($command);
    }
}
