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

namespace App\Users\Domain\Model;

use App\Users\Domain\Exception\UserAlreadyDisabledException;
use App\Users\Domain\Exception\UserNotDisabledYetException;
use App\Users\Domain\Exception\UserPasswordAlreadySetException;
use App\Users\Domain\Exception\UserRoleAlreadyAssignedException;
use App\Users\Domain\Exception\UserRoleNotAssignedException;
use App\Users\Domain\Model\User\UserConfirmationToken;
use App\Users\Domain\Model\User\UserEmail;
use App\Users\Domain\Model\User\UserEncodedPassword;
use App\Users\Domain\Model\User\UserId;
use App\Users\Domain\Model\User\UserName;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity()
 * @ORM\Table("app_user")
 */
class User implements UserInterface
{
    const ROLE_DEFAULT = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    const EDIT = 'edit';
    const PROMOTE = 'promote';
    const DEMOTE = 'demote';
    const DISABLE = 'disable';
    const ENABLE = 'enable';

    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=36)
     * @var string
     */
    private string $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @var string
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $password;

    /**
     * @ORM\Column(type="array")
     * @var array
     */
    private array $roles = [self::ROLE_DEFAULT];

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @var DateTimeImmutable
     */
    private ?DateTimeImmutable $disabledAt = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private ?string $confirmationToken;

    /**
     * User constructor.
     * @param UserId $id
     * @param UserName $name
     * @param UserEmail $email
     * @param UserConfirmationToken $confirmationToken
     */
    public function __construct(UserId $id, UserName $name, UserEmail $email, UserConfirmationToken $confirmationToken)
    {
        $this->id = $id->value();
        $this->name = $name->value();
        $this->email = $email->value();
        $this->confirmationToken = $confirmationToken->value();
    }

    /**
     * @param UserName $name
     */
    public function changeName(UserName $name): void
    {
        $this->name = $name->value();
    }

    /**
     * @param UserEmail $email
     */
    public function changeEmail(UserEmail $email): void
    {
        $this->email = $email->value();
    }

    /**
     * @param UserEncodedPassword $password
     */
    public function changePassword(UserEncodedPassword $password): void
    {
        $this->password = $password->value();
    }

    public function disable(): void
    {
        if ($this->isDisabled()) {
            throw new UserAlreadyDisabledException();
        }

        $this->disabledAt = new DateTimeImmutable();
    }

    /**
     * @return bool
     */
    public function isDisabled(): bool
    {
        return !empty($this->disabledAt);
    }

    public function enable(): void
    {
        if (!$this->isDisabled()) {
            throw new UserNotDisabledYetException();
        }

        $this->disabledAt = null;
    }

    public function getConfirmationToken(): UserConfirmationToken
    {
        return UserConfirmationToken::fromString($this->confirmationToken);
    }

    /**
     * @return bool
     */
    public function isConfirmed(): bool
    {
        return empty($this->confirmationToken);
    }

    public function confirm(): void
    {
        $this->confirmationToken = null;
    }

    /**
     * @throws UserRoleAlreadyAssignedException
     */
    public function promoteToAdmin(): void
    {
        $this->addRole(self::ROLE_ADMIN);
    }

    private function addRole(string $roleToAdd): void
    {
        if ($this->hasRole($roleToAdd)) {
            throw UserRoleAlreadyAssignedException::fromRole($roleToAdd);
        }

        $this->roles[] = $roleToAdd;
    }

    /**
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles);
    }

    /**
     * @throws UserRoleNotAssignedException
     */
    public function demoteFromAdmin(): void
    {
        $this->removeRole(self::ROLE_ADMIN);
    }

    private function removeRole(string $roleToRemove): void
    {
        if (!$this->hasRole($roleToRemove)) {
            throw UserRoleNotAssignedException::fromRole($roleToRemove);
        }

        $newRoles = array_filter($this->roles, function ($role) use ($roleToRemove) {
            return $role !== $roleToRemove;
        });

        $this->roles = $newRoles;
    }

    /**
     * @return UserName
     */
    public function getName(): UserName
    {
        return UserName::fromString($this->name);
    }

    /**
     * @return UserEncodedPassword
     */
    public function getPassword(): UserEncodedPassword
    {
        return UserEncodedPassword::fromString($this->password);
    }

    /**
     * @param UserEncodedPassword $password
     * @throws UserPasswordAlreadySetException
     */
    public function setPassword(UserEncodedPassword $password): void
    {
        if (!empty($this->password)) {
            throw new UserPasswordAlreadySetException(sprintf('User password already set. Use User::changePassword() to change it.'));
        }

        $this->password = $password->value();
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(self::ROLE_ADMIN);
    }

    /**
     * @inheritDoc
     */
    public function getSalt(): void
    {
    }

    /**
     * @inheritDoc
     */
    public function getUsername(): string
    {
        return $this->getEmail()->value();
    }

    /**
     * @return UserEmail
     */
    public function getEmail(): UserEmail
    {
        return UserEmail::fromString($this->email);
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials(): void
    {
    }

    public function isSame(UserId $userId): bool
    {
        return $userId->sameValueAs($this->getId());
    }

    /**
     * @return UserId
     */
    public function getId(): UserId
    {
        return UserId::fromString($this->id);
    }
}
