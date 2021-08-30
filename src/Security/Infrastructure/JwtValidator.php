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

namespace App\Security\Infrastructure;

use App\Security\Application\JwtValidatorInterface;
use Lcobucci\JWT\Token;

class JwtValidator implements JwtValidatorInterface
{
    const HEADER_AUTHORIZATION_BEARER = 'Bearer ';

    public function __construct(
        private JwtConfiguratorInterface $jwtConfigurator,
    )
    {
    }

    public function fromBearerAuthorizationHeader(string $value): bool
    {
        $tokenString = str_replace(self::HEADER_AUTHORIZATION_BEARER, '', $value);

        return $this->fromString($tokenString);
    }

    public function fromString(string $token): bool
    {
        $parser = $this->jwtConfigurator->parser();
        $token = $parser->parse($token);

        return $this->fromToken($token);
    }

    /**
     * @inheritDoc
     */
    public function fromToken(Token $token): bool
    {
        $validator = $this->jwtConfigurator->validator();
        $validationConstraints = $this->jwtConfigurator->validationConstraints();

        return $validator->validate($token, ...$validationConstraints);
    }
}
