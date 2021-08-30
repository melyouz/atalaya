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

namespace App\Security\Infrastructure\Authenticator;

use App\Security\Application\JwtValidatorInterface;
use App\Security\Infrastructure\JwtConfiguratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class SymfonyJwtAuthenticator extends AbstractAuthenticator
{
    public const HEADER_AUTHORIZATION = 'Authorization';
    public const HEADER_AUTHORIZATION_BEARER = 'Bearer ';

    public function __construct(
        private UserProviderInterface $userProvider,
        private JwtValidatorInterface $jwtValidator,
        private JwtConfiguratorInterface $jwtConfigurator,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request): ?bool
    {
        $headers = $request->headers;
        $authorizationHeader = $headers->get(self::HEADER_AUTHORIZATION);

        return !empty($authorizationHeader) && str_starts_with($authorizationHeader, self::HEADER_AUTHORIZATION_BEARER);
    }

    /**
     * @inheritDoc
     */
    public function authenticate(Request $request): PassportInterface
    {
        $parser = $this->jwtConfigurator->parser();
        $token = $request->headers->get(self::HEADER_AUTHORIZATION);
        $token = $parser->parse(str_replace(self::HEADER_AUTHORIZATION_BEARER, '', $token));
        $userId = $token->claims()->get('sub', '');

        if (!$userId || !$user = $this->userProvider->loadUserById($userId)) {
            throw new UnauthorizedHttpException('Bearer');
        }

        $isTokenValid = $this->jwtValidator->fromToken($token);
        $isUserActive = !$user->isDisabled();

        if (!$isTokenValid || !$isUserActive) {
            throw new UnauthorizedHttpException('Bearer');
        }

        return new SelfValidatingPassport(new UserBadge($user->getUserIdentifier()));
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey): ?Response
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new Response('', Response::HTTP_UNAUTHORIZED);
    }
}
