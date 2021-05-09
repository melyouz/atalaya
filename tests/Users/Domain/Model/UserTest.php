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

namespace Tests\Users\Domain\Model;

use App\Users\Domain\Exception\UserPasswordAlreadySetException;
use App\Users\Domain\Exception\UserRoleAlreadyAssignedException;
use App\Users\Domain\Exception\UserRoleNotAssignedException;
use App\Users\Domain\Model\User;
use App\Users\Domain\Model\User\UserConfirmationToken;
use App\Users\Domain\Model\User\UserEmail;
use App\Users\Domain\Model\User\UserEncodedPassword;
use App\Users\Domain\Model\User\UserId;
use App\Users\Domain\Model\User\UserName;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    public function testHasId(): void
    {
        $this->assertInstanceOf(UserId::class, $this->user->getId());
        $this->assertEquals('3c9ec32a-9c3a-4be1-b64d-0a0bb6ddf28f', $this->user->getId()->value());
    }

    public function testHasName(): void
    {
        $this->assertInstanceOf(UserName::class, $this->user->getName());
        $this->assertEquals('John Doe', $this->user->getName()->value());
    }

    public function testHasEmail(): void
    {
        $this->assertInstanceOf(UserEmail::class, $this->user->getEmail());
        $this->assertEquals('johndoe@awesome-project.dev', $this->user->getEmail()->value());
    }

    public function testHasUsername(): void
    {
        $this->assertEquals('johndoe@awesome-project.dev', $this->user->getUsername());
    }

    public function testHasPassword(): void
    {
        $this->assertInstanceOf(UserEncodedPassword::class, $this->user->getPassword());
        $this->assertEquals('WhateverEncodedPassword', $this->user->getPassword()->value());
    }

    public function testPasswordCannotBeSetTwice(): void
    {
        $this->expectException(UserPasswordAlreadySetException::class);
        $this->user->setPassword(UserEncodedPassword::fromString('TestPassword'));
    }

    public function testHasDefaultRole(): void
    {
        $this->assertCount(1, $this->user->getRoles());
        $this->assertTrue($this->user->hasRole('ROLE_USER'));
    }

    public function testIsNotAdmin(): void
    {
        $this->assertFalse($this->user->isAdmin());
    }

    public function testPromoteToAdmin(): void
    {
        $this->user->promoteToAdmin();
        $this->assertTrue($this->user->isAdmin());
    }

    public function testPromoteToAdminFailsWhenUserIsAlreadyAdmin(): void
    {
        $this->user->promoteToAdmin();
        $this->expectException(UserRoleAlreadyAssignedException::class);
        $this->user->promoteToAdmin();
    }

    public function testDemoteFromAdmin(): void
    {
        $this->user->promoteToAdmin();
        $this->user->demoteFromAdmin();
        $this->assertFalse($this->user->isAdmin());
    }

    public function testDemoteFromAdminFailsWhenUserIsNotAnAdmin(): void
    {
        $this->expectException(UserRoleNotAssignedException::class);
        $this->user->demoteFromAdmin();
    }

    public function testGetSalt(): void
    {
        $this->assertEmpty($this->user->getSalt());
    }

    public function testEraseCredentialsNotDoingAnything(): void
    {
        $oldUser = clone $this->user;
        $this->user->eraseCredentials();
        $this->assertNotSame($oldUser, $this->user);
        $this->assertEquals($oldUser, $this->user);
    }

    public function testIsSame(): void
    {
        $other = clone $this->user;
        $other->changeName(UserName::fromString('Jane Doe'));
        $this->assertTrue($this->user->isSame($other->getId()));
    }

    public function testIsNotSame(): void
    {
        $id = 'ad1e8628-9d9d-41f8-80c2-df54d8735405';
        $name = 'John Doe';
        $email = 'johndoe@awesome-project.dev';
        $password = 'WhateverEncodedPassword';
        $other = new User(UserId::fromString($id), UserName::fromString($name), UserEmail::fromString($email), UserConfirmationToken::fromString('someRandomToken'));
        $other->setPassword(UserEncodedPassword::fromString($password));

        $this->assertFalse($this->user->isSame($other->getId()));
    }

    public function testHasConfirmationToken(): void
    {
        $this->assertInstanceOf(UserConfirmationToken::class, $this->user->getConfirmationToken());
        $this->assertEquals('someRandomToken', $this->user->getConfirmationToken()->value());
    }

    protected function setUp(): void
    {
        $id = '3c9ec32a-9c3a-4be1-b64d-0a0bb6ddf28f';
        $name = 'John Doe';
        $email = 'johndoe@awesome-project.dev';
        $password = 'WhateverEncodedPassword';
        $this->user = new User(UserId::fromString($id), UserName::fromString($name), UserEmail::fromString($email), UserConfirmationToken::fromString('someRandomToken'));
        $this->user->setPassword(UserEncodedPassword::fromString($password));
    }
}
