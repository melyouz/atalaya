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

use App\Security\Application\AuthServiceInterface;
use App\Security\Domain\Exception\UserNotLoggedInException;
use App\Users\Domain\Model\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use function is_object;

class SymfonyAuthService implements AuthServiceInterface
{
    /**
     * @var TokenStorageInterface
     */
    private TokenStorageInterface $tokenStorage;

    /**
     * @var AuthorizationCheckerInterface
     */
    private AuthorizationCheckerInterface $authorizationChecker;

    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @inheritDoc
     */
    public function getLoggedInUser(): User
    {
        if (null === $token = $this->tokenStorage->getToken()) {
            throw new UserNotLoggedInException();
        }

        /** @var User|string $user */
        $user = $token->getUser();

        if (!is_object($user)) {
            // e.g. anonymous authentication
            throw new UserNotLoggedInException();
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function isGranted($attributes, $subject): bool
    {
        return $this->authorizationChecker->isGranted($attributes, $subject);
    }
}
