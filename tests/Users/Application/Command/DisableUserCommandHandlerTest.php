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

use App\Users\Application\Command\DisableUserCommand;
use App\Users\Application\Command\DisableUserCommandHandler;
use App\Users\Domain\Exception\UserAlreadyDisabledException;
use App\Users\Domain\Model\User;
use App\Users\Domain\Model\UserEmail;
use App\Users\Domain\Model\UserEncodedPassword;
use App\Users\Domain\Model\UserId;
use App\Users\Domain\Model\UserName;
use App\Users\Domain\Repository\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

class DisableUserCommandHandlerTest extends TestCase
{
    private User $user;
    private DisableUserCommand $command;
    private DisableUserCommandHandler $handler;

    protected function setUp()
    {
        $id = '3c9ec32a-9c3a-4be1-b64d-0a0bb6ddf28f';
        $name = 'John Doe';
        $email = 'johndoe@awesome-project.dev';
        $encodedPassword = 'WhateverEncodedPassword';

        $this->user = User::register(UserId::fromString($id), UserName::fromString($name), UserEmail::fromString($email));
        $this->user->setPassword(UserEncodedPassword::fromString($encodedPassword));
        $this->command = new DisableUserCommand($id);
        $repoMock = $this->createMock(UserRepositoryInterface::class);
        $repoMock->expects($this->once())
            ->method('get')
            ->with(UserId::fromString($id))
            ->willReturn($this->user);

        $this->handler = new DisableUserCommandHandler($repoMock);
    }

    public function testDisableUser()
    {
        $this->handler->__invoke($this->command);
        $this->assertTrue($this->user->isDisabled());
    }

    public function testUserCannotBeDisabledTwice()
    {
        $this->user->disable();
        $this->expectException(UserAlreadyDisabledException::class);
        $this->handler->__invoke($this->command);
    }
}
