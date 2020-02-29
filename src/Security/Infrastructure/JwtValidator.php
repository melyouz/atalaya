<?php
/**
 *
 * @copyright 2020 Mohammadi El Youzghi. All rights reserved
 * @author    Mohammadi El Youzghi (mo.elyouzghi@gmail.com)
 *
 * @link      https://github.com/ayrad
 *
 * @licence   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

declare(strict_types=1);

namespace App\Security\Infrastructure;

use App\Security\Application\JwtValidatorInterface;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Token;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class JwtValidator implements JwtValidatorInterface
{
    const HEADER_AUTHORIZATION_BEARER = 'Bearer ';

    /**
     * @var ParameterBagInterface
     */
    private ParameterBagInterface $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public function fromBearerAuthorizationHeader(string $value): bool
    {
        $tokenString = str_replace(self::HEADER_AUTHORIZATION_BEARER, '', $value);

        return $this->fromString($tokenString);
    }

    public function fromString(string $token): bool
    {
        $token = (new Parser())->parse($token);

        return $this->fromToken($token);
    }

    /**
     * @inheritDoc
     */
    public function fromToken(Token $token): bool
    {
        $signer = new Sha256();
        $publicKey = new Key(file_get_contents($this->parameterBag->get('app_jwt_public_key')));

        $isTokenValid = $token->verify($signer, $publicKey);
        $isTokenNotExpired = !$token->isExpired();

        return $isTokenValid && $isTokenNotExpired;
    }
}
