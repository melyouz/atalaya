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

namespace App\Issues\Infrastructure\Symfony\Authorization;

use App\Issues\Domain\Model\Issue;
use App\Projects\Domain\Model\Project;
use App\Projects\Domain\Repository\ProjectRepositoryInterface;
use App\Users\Domain\Model\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class IssueVoter extends Voter
{
    /**
     * @var ProjectRepositoryInterface
     */
    private ProjectRepositoryInterface $projectRepo;

    public function __construct(ProjectRepositoryInterface $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    /**
     * @inheritDoc
     */
    protected function supports(string $attribute, $subject)
    {
        $actions = [Issue::VIEW, Issue::RESOLVE, Issue::UNRESOLVE];

        if (!in_array($attribute, $actions)) {
            return false;
        }

        if (!$subject instanceof Issue) {
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

        /** @var Issue $issue */
        $issue = $subject;

        /** @var Project $project */
        $project = $this->projectRepo->get($issue->getProjectId());

        switch ($attribute) {
            case Issue::VIEW:
            case Issue::RESOLVE:
            case Issue::UNRESOLVE:
                return $loggedInUser->isAdmin() || $project->isOwner($loggedInUser->getId());
        }

        return false;
    }
}
