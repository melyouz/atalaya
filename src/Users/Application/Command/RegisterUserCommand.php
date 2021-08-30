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

use App\Shared\Application\Command\CommandInterface;
use App\Users\Domain\Model\User\UserEmail;
use App\Users\Domain\Model\User\UserId;
use App\Users\Domain\Model\User\UserName;
use App\Users\Domain\Model\User\UserPlainPassword;

class RegisterUserCommand implements CommandInterface
{
    private UserId $id;

    private UserName $name;

    private UserEmail $email;

    private UserPlainPassword $plainPassword;

    public function __construct(string $id, string $name, string $email, string $plainPassword)
    {
        $this->id = UserId::fromString($id);
        $this->name = UserName::fromString($name);
        $this->email = UserEmail::fromString($email);
        $this->plainPassword = UserPlainPassword::fromString($plainPassword);
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getName(): UserName
    {
        return $this->name;
    }

    public function getEmail(): UserEmail
    {
        return $this->email;
    }

    public function getPlainPassword(): UserPlainPassword
    {
        return $this->plainPassword;
    }
}
