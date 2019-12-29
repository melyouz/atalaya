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

namespace App\Users\Infrastructure\Symfony;

use App\Users\Application\Encoder\UserPasswordEncoderInterface;
use App\Users\Domain\Model\User;
use App\Users\Domain\Model\UserPlainPassword;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface as SymfonyUserPasswordEncoderInterface;

class UserPasswordEncoder implements UserPasswordEncoderInterface
{

    /**
     * @var SymfonyUserPasswordEncoderInterface
     */
    private SymfonyUserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(SymfonyUserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @inheritDoc
     */
    public function encodePassword(User $user, UserPlainPassword $plainPassword): string
    {
        return $this->userPasswordEncoder->encodePassword($user, $plainPassword->value());
    }
}
