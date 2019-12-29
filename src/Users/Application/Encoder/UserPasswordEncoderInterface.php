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

namespace App\Users\Application\Encoder;

use App\Users\Domain\Model\User;
use App\Users\Domain\Model\UserPlainPassword;

interface UserPasswordEncoderInterface
{
    /**
     * @param User   $user
     * @param UserPlainPassword $plainPassword
     *
     * @return string
     */
    public function encodePassword(User $user, UserPlainPassword $plainPassword): string;
}
