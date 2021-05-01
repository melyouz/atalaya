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

use App\Users\Application\Command\PromoteUserToAdminCommand;
use App\Users\Application\Command\PromoteUserToAdminCommandHandler;
use App\Users\Domain\Exception\UserRoleAlreadyAssignedException;
use App\Users\Domain\Model\User;
use App\Users\Domain\Model\User\UserConfirmationToken;
use App\Users\Domain\Model\User\UserEmail;
use App\Users\Domain\Model\User\UserEncodedPassword;
use App\Users\Domain\Model\User\UserId;
use App\Users\Domain\Model\User\UserName;
use App\Users\Domain\Repository\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

class PromoteUserToAdminCommandHandlerTest extends TestCase
{
    private User $user;
    private PromoteUserToAdminCommand $command;
    private PromoteUserToAdminCommandHandler $handler;

    protected function setUp(): void
    {
        $id = '3c9ec32a-9c3a-4be1-b64d-0a0bb6ddf28f';
        $name = 'John Doe';
        $email = 'johndoe@awesome-project.dev';
        $encodedPassword = 'WhateverEncodedPassword';

        $this->user = new User(UserId::fromString($id), UserName::fromString($name), UserEmail::fromString($email), UserConfirmationToken::fromString('someRandomToken'));
        $this->user->setPassword(UserEncodedPassword::fromString($encodedPassword));
        $this->command = new PromoteUserToAdminCommand($id);
        $repoMock = $this->createMock(UserRepositoryInterface::class);
        $repoMock->expects($this->once())
            ->method('get')
            ->with(UserId::fromString($id))
            ->willReturn($this->user);

        $this->handler = new PromoteUserToAdminCommandHandler($repoMock);
    }

    public function testPromoteUser()
    {
        $this->handler->__invoke($this->command);
        $this->assertTrue($this->user->isAdmin());
    }

    public function testUserCannotBePromotedTwice()
    {
        $this->user->promoteToAdmin();
        $this->expectException(UserRoleAlreadyAssignedException::class);
        $this->handler->__invoke($this->command);
    }
}
