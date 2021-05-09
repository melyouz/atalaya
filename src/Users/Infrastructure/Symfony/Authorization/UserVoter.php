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

namespace App\Users\Infrastructure\Symfony\Authorization;

use App\Users\Domain\Model\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    /**
     * @inheritDoc
     */
    protected function supports(string $attribute, $subject)
    {
        $actions = [User::EDIT, User::PROMOTE, User::DEMOTE, User::DISABLE, User::ENABLE];

        if (!in_array($attribute, $actions)) {
            return false;
        }

        if (!$subject instanceof User) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        /** @var User $loggedInUser */
        $loggedInUser = $token->getUser();

        if (!$loggedInUser instanceof User) {
            return false;
        }

        /** @var User $user */
        $user = $subject;

        switch ($attribute) {
            case User::EDIT:
                return $loggedInUser->isAdmin() || $user->isSame($loggedInUser->getId());
            case User::PROMOTE:
            case User::DEMOTE:
            case User::DISABLE:
            case User::ENABLE:
                return $loggedInUser->isAdmin();
        }

        return false;
    }
}
