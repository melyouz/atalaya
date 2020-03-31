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

namespace App\Security\Infrastructure\Authenticator;

use App\Security\Application\JwtValidatorInterface;
use App\Users\Domain\Exception\UserNotFoundException;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Token;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class SymfonyJwtAuthenticator extends AbstractGuardAuthenticator
{
    const HEADER_AUTHORIZATION = 'Authorization';
    const HEADER_AUTHORIZATION_BEARER = 'Bearer ';

    /**
     * @var UserProviderInterface
     */
    private UserProviderInterface $userProvider;

    /**
     * @var JwtValidatorInterface
     */
    private JwtValidatorInterface $jwtValidator;

    public function __construct(UserProviderInterface $userProvider, JwtValidatorInterface $jwtValidator)
    {
        $this->userProvider = $userProvider;
        $this->jwtValidator = $jwtValidator;
    }

    /**
     * @inheritDoc
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new Response('Login required.', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request)
    {
        $headers = $request->headers;
        $authorizationHeader = $headers->get(self::HEADER_AUTHORIZATION);

        return !empty($authorizationHeader) && 0 === strpos($authorizationHeader, self::HEADER_AUTHORIZATION_BEARER);
    }

    /**
     * @inheritDoc
     */
    public function getCredentials(Request $request)
    {
        $token = $request->headers->get(self::HEADER_AUTHORIZATION);
        $token = (new Parser())->parse(str_replace(self::HEADER_AUTHORIZATION_BEARER, '', $token));

        return [
            'token' => $token,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var Token $token */
        $token = $credentials['token'];

        if (!$userId = $token->getClaim('sub', '')) {
            return null;
        }

        try {
            return $this->userProvider->loadUserById($userId);
        } catch(UserNotFoundException $e) {
            return null;
        }
    }

    /**
     * @inheritDoc
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        /** @var Token $token */
        $token = $credentials['token'];

        $isTokenValid = $this->jwtValidator->fromToken($token);
        $isUserActive = !$user->isDisabled();

        return $isUserActive && $isTokenValid;
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new Response('', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function supportsRememberMe()
    {
        return false;
    }
}
