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

namespace App\Users\Domain\Model;

use App\Users\Domain\Exception\UserAlreadyDisabledException;
use App\Users\Domain\Exception\UserNotDisabledYetException;
use App\Users\Domain\Exception\UserPasswordAlreadySetException;
use App\Users\Domain\Exception\UserRoleAlreadyAssignedException;
use App\Users\Domain\Exception\UserRoleNotAssignedException;
use App\Users\Domain\Model\User\UserConfirmationToken;
use App\Users\Domain\Model\User\UserEmail;
use App\Users\Domain\Model\User\UserHashedPassword;
use App\Users\Domain\Model\User\UserId;
use App\Users\Domain\Model\User\UserName;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity()
 * @ORM\Table("app_user")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const ROLE_DEFAULT = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    public const EDIT = 'edit';
    public const PROMOTE = 'promote';
    public const DEMOTE = 'demote';
    public const DISABLE = 'disable';
    public const ENABLE = 'enable';

    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=36)
     */
    private string $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $password;

    /**
     * @ORM\Column(type="array")
     */
    private array $roles = [self::ROLE_DEFAULT];

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     *
     * @var DateTimeImmutable
     */
    private ?DateTimeImmutable $disabledAt = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $confirmationToken;

    /**
     * User constructor.
     */
    public function __construct(UserId $id, UserName $name, UserEmail $email, UserConfirmationToken $confirmationToken)
    {
        $this->id = $id->value();
        $this->name = $name->value();
        $this->email = $email->value();
        $this->confirmationToken = $confirmationToken->value();
    }

    public function changeName(UserName $name): void
    {
        $this->name = $name->value();
    }

    public function changeEmail(UserEmail $email): void
    {
        $this->email = $email->value();
    }

    public function changePassword(UserHashedPassword $password): void
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

    public function getName(): UserName
    {
        return UserName::fromString($this->name);
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @throws UserPasswordAlreadySetException
     */
    public function setPassword(UserHashedPassword $password): void
    {
        if (!empty($this->password)) {
            throw new UserPasswordAlreadySetException(sprintf('User password already set. Use User::changePassword() to change it.'));
        }

        $this->password = $password->value();
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

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
        return $this->getUserIdentifier();
    }

    /**
     * @inheritDoc
     */
    public function getUserIdentifier(): string
    {
        return $this->getEmail()->value();
    }

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

    public function getId(): UserId
    {
        return UserId::fromString($this->id);
    }
}
