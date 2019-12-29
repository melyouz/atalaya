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

namespace App\Users\Application\Command;

use App\Shared\Application\Command\CommandInterface;
use App\Users\Domain\Model\UserEmail;
use App\Users\Domain\Model\UserId;
use App\Users\Domain\Model\UserName;
use App\Users\Domain\Model\UserPlainPassword;

class RegisterUserCommand implements CommandInterface
{
    /**
     * @var UserId
     */
    private UserId $id;

    /**
     * @var UserName
     */
    private UserName $name;

    /**
     * @var UserEmail
     */
    private UserEmail $email;

    /**
     * @var UserPlainPassword
     */
    private UserPlainPassword $plainPassword;

    public function __construct(string $id, string $name, string $email, string $plainPassword)
    {
        $this->id = UserId::fromString($id);
        $this->name = UserName::fromString($name);
        $this->email = UserEmail::fromString($email);
        $this->plainPassword = UserPlainPassword::fromString($plainPassword);
    }

    /**
     * @return UserId
     */
    public function getId(): UserId
    {
        return $this->id;
    }

    /**
     * @return UserName
     */
    public function getName(): UserName
    {
        return $this->name;
    }

    /**
     * @return UserEmail
     */
    public function getEmail(): UserEmail
    {
        return $this->email;
    }

    /**
     * @return UserPlainPassword
     */
    public function getPlainPassword(): UserPlainPassword
    {
        return $this->plainPassword;
    }
}
