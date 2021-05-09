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

namespace Tests\Users\Application\Command;

use App\Users\Application\Command\EnableUserCommand;
use App\Users\Application\Command\EnableUserCommandHandler;
use App\Users\Domain\Exception\UserNotDisabledYetException;
use App\Users\Domain\Model\User;
use App\Users\Domain\Model\User\UserConfirmationToken;
use App\Users\Domain\Model\User\UserEmail;
use App\Users\Domain\Model\User\UserEncodedPassword;
use App\Users\Domain\Model\User\UserId;
use App\Users\Domain\Model\User\UserName;
use App\Users\Domain\Repository\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

class EnableUserCommandHandlerTest extends TestCase
{
    private User $user;
    private EnableUserCommand $command;
    private EnableUserCommandHandler $handler;

    public function testEnableUser()
    {
        $this->user->disable();
        $this->handler->__invoke($this->command);
        $this->assertFalse($this->user->isDisabled());
    }

    public function testUserCannotBeEnabledTwice()
    {
        $this->expectException(UserNotDisabledYetException::class);
        $this->handler->__invoke($this->command);
    }

    protected function setUp(): void
    {
        $id = '3c9ec32a-9c3a-4be1-b64d-0a0bb6ddf28f';
        $name = 'John Doe';
        $email = 'johndoe@awesome-project.dev';
        $encodedPassword = 'WhateverEncodedPassword';

        $this->user = new User(UserId::fromString($id), UserName::fromString($name), UserEmail::fromString($email), UserConfirmationToken::fromString('someRandomToken'));
        $this->user->setPassword(UserEncodedPassword::fromString($encodedPassword));
        $this->command = new EnableUserCommand($id);
        $repoMock = $this->createMock(UserRepositoryInterface::class);
        $repoMock->expects($this->once())
            ->method('get')
            ->with(UserId::fromString($id))
            ->willReturn($this->user);

        $this->handler = new EnableUserCommandHandler($repoMock);
    }
}
