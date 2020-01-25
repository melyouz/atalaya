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

use App\Security\Application\UserPasswordEncoderInterface;
use App\Users\Domain\Model\User;
use App\Users\Domain\Model\UserPlainPassword;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class SymfonyUsernamePasswordAuthenticator extends AbstractGuardAuthenticator
{
    const ROUTE_JWT_TOKEN = 'app_security_jwt_token';
    const PARAM_USERNAME = 'username';
    const PARAM_PASSWORD = 'password';

    /**
     * @var UserProviderInterface
     */
    private UserProviderInterface $userProvider;

    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $userPasswordEncoder;

    /**
     * @var ParameterBagInterface
     */
    private ParameterBagInterface $parameterBag;

    public function __construct(UserProviderInterface $userProvider, UserPasswordEncoderInterface $userPasswordEncoder, ParameterBagInterface $parameterBag)
    {
        $this->userProvider = $userProvider;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->parameterBag = $parameterBag;
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
        return $request->get('_route') === self::ROUTE_JWT_TOKEN && $request->getMethod() === Request::METHOD_POST;
    }

    /**
     * @inheritDoc
     */
    public function getCredentials(Request $request)
    {
        return [
            self::PARAM_USERNAME => $request->request->get(self::PARAM_USERNAME, null),
            self::PARAM_PASSWORD => $request->request->get(self::PARAM_PASSWORD, null),
        ];
    }

    /**
     * @inheritDoc
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials[self::PARAM_USERNAME];
        $password = $credentials[self::PARAM_PASSWORD];

        if (empty($username) || empty($password)) {
            return;
        }

        return $this->userProvider->loadUserByUsername($username);
    }

    /**
     * @inheritDoc
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        $password = $credentials[self::PARAM_PASSWORD];

        $isUserConfirmed = $user->isConfirmed();
        $isUserActive = !$user->isDisabled();
        $isPasswordValid = $this->userPasswordEncoder->isPasswordValid($user, UserPlainPassword::fromString($password));

        return $isUserConfirmed && $isUserActive && $isPasswordValid;
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
        return new JsonResponse(['token' => $this->buildToken($token->getUser())]);
    }

    /**
     * @inheritDoc
     */
    public function supportsRememberMe()
    {
        return false;
    }

    /**
     * @param User $user
     * @return string
     */
    private function buildToken(User $user): string
    {
        $signer = new Sha256();
        $privateKey = new Key(file_get_contents($this->parameterBag->get('app_jwt_private_key')));
        $time = time();

        $builder = new Builder();
        $token = $builder
            ->relatedTo($user->getId()->value())
            ->issuedAt($time)
            ->expiresAt($time + 28800) // 8H
            ->withClaim('roles', $user->getRoles())
            ->getToken($signer, $privateKey);

        return $token->__toString();
    }
}
