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

namespace App\Security\Application;

use Lcobucci\JWT\Token;

interface JwtValidatorInterface
{
    /**
     * @return mixed
     */
    public function fromToken(Token $token): bool;

    public function fromString(string $token): bool;

    public function fromBearerAuthorizationHeader(string $value): bool;
}
