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

namespace App\Security\Infrastructure\Hasher;

use App\Security\Application\Hasher\UserPasswordHasherInterface;
use App\Users\Domain\Model\User;
use App\Users\Domain\Model\User\UserPlainPassword;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface as SymfonyUserPasswordHasherInterface;

class SymfonyUserPasswordHasher implements UserPasswordHasherInterface
{
    private SymfonyUserPasswordHasherInterface $userPasswordHasher;

    public function __construct(SymfonyUserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * @inheritDoc
     */
    public function hashPassword(User $user, UserPlainPassword $plainPassword): string
    {
        return $this->userPasswordHasher->hashPassword($user, $plainPassword->value());
    }

    /**
     * @inheritDoc
     */
    public function isPasswordValid(User $user, UserPlainPassword $plainPassword): bool
    {
        return $this->userPasswordHasher->isPasswordValid($user, $plainPassword->value());
    }
}
