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

namespace Tests\Users\Domain\Model;

use App\Users\Domain\Exception\UserRoleAlreadyAssignedException;
use App\Users\Domain\Exception\UserRoleNotAssignedException;
use App\Users\Domain\Model\User;
use App\Users\Domain\Model\UserConfirmationToken;
use App\Users\Domain\Model\UserEmail;
use App\Users\Domain\Model\UserEncodedPassword;
use App\Users\Domain\Model\UserId;
use App\Users\Domain\Model\UserName;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        $id = '3c9ec32a-9c3a-4be1-b64d-0a0bb6ddf28f';
        $name = 'John Doe';
        $email = 'johndoe@awesome-project.dev';
        $password = 'WhateverEncodedPassword';
        $this->user = User::register(UserId::fromString($id), UserName::fromString($name), UserEmail::fromString($email), UserConfirmationToken::fromString('someRandomToken'));
        $this->user->setPassword(UserEncodedPassword::fromString($password));
    }

    public function testRegisteredUserHasId(): void
    {
        $this->assertInstanceOf(UserId::class, $this->user->getId());
        $this->assertEquals('3c9ec32a-9c3a-4be1-b64d-0a0bb6ddf28f', $this->user->getId()->value());
    }

    public function testRegisteredUserHasName(): void
    {
        $this->assertInstanceOf(UserName::class, $this->user->getName());
        $this->assertEquals('John Doe', $this->user->getName()->value());
    }

    public function testRegisteredUserHasEmail(): void
    {
        $this->assertInstanceOf(UserEmail::class, $this->user->getEmail());
        $this->assertEquals('johndoe@awesome-project.dev', $this->user->getEmail()->value());
    }

    public function testRegisteredUserHasUsername(): void
    {
        $this->assertEquals('johndoe@awesome-project.dev', $this->user->getUsername());
    }

    public function testRegisteredUserHasPassword(): void
    {
        $this->assertInstanceOf(UserEncodedPassword::class, $this->user->getPassword());
        $this->assertEquals('WhateverEncodedPassword', $this->user->getPassword()->value());
    }

    public function testRegisteredUserPasswordCannotBeSetTwice(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->user->setPassword(UserEncodedPassword::fromString('TestPassword'));
    }

    public function testRegisteredUserHasDefaultRole(): void
    {
        $this->assertCount(1, $this->user->getRoles());
        $this->assertTrue($this->user->hasRole('ROLE_USER'));
    }

    public function testRegisteredUserIsNotAdmin(): void
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
}
