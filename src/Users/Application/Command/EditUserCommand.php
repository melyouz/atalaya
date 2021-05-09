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

class EditUserCommand implements CommandInterface
{
    /**
     * @var UserId
     */
    private UserId $id;

    /**
     * @var UserName
     */
    private ?UserName $name;

    /**
     * @var UserEmail
     */
    private ?UserEmail $email;

    /**
     * @var UserPlainPassword
     */
    private ?UserPlainPassword $plainPassword;

    public function __construct(string $id, ?string $name, ?string $email, ?string $plainPassword)
    {
        $this->id = UserId::fromString($id);
        $this->name = ($name ? UserName::fromString($name) : null);
        $this->email = ($email ? UserEmail::fromString($email) : null);
        $this->plainPassword = ($plainPassword ? UserPlainPassword::fromString($plainPassword) : null);
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
    public function getName(): ?UserName
    {
        return $this->name;
    }

    /**
     * @return UserEmail
     */
    public function getEmail(): ?UserEmail
    {
        return $this->email;
    }

    /**
     * @return UserPlainPassword
     */
    public function getPlainPassword(): ?UserPlainPassword
    {
        return $this->plainPassword;
    }
}
