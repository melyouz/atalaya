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

use App\Users\Application\Command\ConfirmUserCommand;
use App\Users\Application\Command\ConfirmUserCommandHandler;
use App\Users\Domain\Model\User;
use App\Users\Domain\Model\UserConfirmationToken;
use App\Users\Domain\Model\UserEmail;
use App\Users\Domain\Model\UserEncodedPassword;
use App\Users\Domain\Model\UserId;
use App\Users\Domain\Model\UserName;
use App\Users\Domain\Repository\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

class ConfirmUserCommandHandlerTest extends TestCase
{
    private User $user;
    private ConfirmUserCommand $command;
    private ConfirmUserCommandHandler $handler;

    protected function setUp()
    {
        $id = '3c9ec32a-9c3a-4be1-b64d-0a0bb6ddf28f';
        $name = 'John Doe';
        $email = 'johndoe@awesome-project.dev';
        $encodedPassword = 'WhateverEncodedPassword';
        $token = 'someRandomToken';

        $this->user = User::register(UserId::fromString($id), UserName::fromString($name), UserEmail::fromString($email), UserConfirmationToken::fromString($token));
        $this->user->setPassword(UserEncodedPassword::fromString($encodedPassword));
        $this->command = new ConfirmUserCommand($token);
        $repoMock = $this->createMock(UserRepositoryInterface::class);
        $repoMock->expects($this->once())
            ->method('getByToken')
            ->with(UserConfirmationToken::fromString($token))
            ->willReturn($this->user);

        $this->handler = new ConfirmUserCommandHandler($repoMock);
    }

    public function testConfirmUser()
    {
        $this->handler->__invoke($this->command);
        $this->assertTrue($this->user->isConfirmed());
    }
}
