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

namespace App\Projects\Infrastructure\Symfony\Authorization;

use App\Projects\Domain\Model\Project;
use App\Users\Domain\Model\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ProjectVoter extends Voter
{
    /**
     * @inheritDoc
     */
    protected function supports(string $attribute, $subject)
    {
        $actions = [Project::VIEW, Project::LIST_ISSUES, Project::EDIT, Project::ARCHIVE, Project::UNARCHIVE];

        if (!in_array($attribute, $actions)) {
            return false;
        }

        if (!$subject instanceof Project) {
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

        /** @var Project $project */
        $project = $subject;

        switch ($attribute) {
            case Project::VIEW:
            case Project::LIST_ISSUES:
            case Project::EDIT:
            case Project::ARCHIVE:
            case Project::UNARCHIVE:
                return $loggedInUser->isAdmin() || $project->isOwner($loggedInUser->getId());
        }

        return false;
    }
}
