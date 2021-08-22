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

use App\Security\Application\JwtGeneratorInterface;
use App\Users\Domain\Model\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class SymfonyUsernamePasswordAuthenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{
    const ROUTE_JWT_TOKEN = 'app_security_jwt_token';
    const PARAM_USERNAME = 'username';
    const PARAM_PASSWORD = 'password';

    private JwtGeneratorInterface $jwtGenerator;
    private UserProviderInterface $userProvider;

    public function __construct(UserProviderInterface $userProvider, JwtGeneratorInterface $jwtGenerator)
    {
        $this->jwtGenerator = $jwtGenerator;
        $this->userProvider = $userProvider;
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request): ?bool
    {
        return $request->get('_route') === self::ROUTE_JWT_TOKEN && $request->getMethod() === Request::METHOD_POST;
    }

    /**
     * @inheritDoc
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new Response('Login required.', Response::HTTP_UNAUTHORIZED);
    }

    public function authenticate(Request $request): PassportInterface
    {
        $username = $request->request->get(self::PARAM_USERNAME, null);
        $password = $request->request->get(self::PARAM_PASSWORD, null);

        if (!$user = $this->userProvider->loadUserByIdentifier($username)) {
            throw new UnauthorizedHttpException('Bearer');
        }

        $isUserConfirmed = $user->isConfirmed();
        $isUserActive = !$user->isDisabled();

        if (!$isUserConfirmed || !$isUserActive) {
            throw new UnauthorizedHttpException('Bearer');
        }

        return new Passport(new UserBadge($username), new PasswordCredentials($password));
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        /** @var User $user */
        $user = $token->getUser();

        return new JsonResponse(['token' => $this->jwtGenerator->forUser($user)]);
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new Response('', Response::HTTP_UNAUTHORIZED);
    }
}
