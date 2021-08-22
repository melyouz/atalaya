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
use App\Users\Application\Command\EditUserCommand;
use App\Users\Application\Command\EditUserCommandHandler;
use App\Users\Domain\Model\User;
use App\Users\Domain\Model\User\UserConfirmationToken;
use App\Users\Domain\Model\User\UserEmail;
use App\Users\Domain\Model\User\UserHashedPassword;
use App\Users\Domain\Model\User\UserId;
use App\Users\Domain\Model\User\UserName;
use App\Users\Domain\Repository\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

class EditUserCommandHandlerTest extends TestCase
{
    public function testEditUser()
    {
        $id = '3c9ec32a-9c3a-4be1-b64d-0a0bb6ddf28f';
        $name = 'John Doe';
        $email = 'johndoe@awesome-project.dev';
        $encodedPassword = 'WhateverEncodedPassword';
        $newName = 'Jane Doe';
        $newEmail = 'janedoe@awesome-project.dev';
        $newPlainPassword = '-_-WhateverPlainPassword-_-';
        $newEncodedPassword = '-_-WhateverEncodedPassword-_-';

        $user = new User(UserId::fromString($id), UserName::fromString($name), UserEmail::fromString($email), UserConfirmationToken::fromString('someRandomToken'));
        $user->setPassword(UserHashedPassword::fromString($encodedPassword));

        $newUser = new User(UserId::fromString($id), UserName::fromString($newName), UserEmail::fromString($newEmail), UserConfirmationToken::fromString('someRandomToken'));
        $newUser->setPassword(UserHashedPassword::fromString($newEncodedPassword));

        $command = new EditUserCommand($id, $newName, $newEmail, $newPlainPassword);

        $userPasswordEncoderMock = $this->createMock(UserPasswordHasherInterface::class);
        $userPasswordEncoderMock->expects($this->once())
            ->method('hashPassword')
            ->with($user, $newPlainPassword)
            ->willReturn($newEncodedPassword);

        $repoMock = $this->createMock(UserRepositoryInterface::class);
        $repoMock->expects($this->once())
            ->method('save')
            ->with($newUser);
        $repoMock->expects($this->once())
            ->method('get')
            ->with(UserId::fromString($id))
            ->willReturn($user);

        $handler = new EditUserCommandHandler($repoMock, $userPasswordEncoderMock);
        $handler->__invoke($command);
    }
}
