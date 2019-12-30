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

namespace App\Shared\Application\Util;

class TokenGenerator
{
    public const DEFAULT_LENGTH = 32;

    /**
     * @param int $length
     * @return string
     * @throws \Exception
     */
    public function randomToken(int $length = self::DEFAULT_LENGTH): string
    {
        return bin2hex(random_bytes($length / 2));
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function md5RandomToken(): string
    {
        return md5($this->randomToken());
    }
}
