<?php
/**
 *
 * @copyright 2019 Mohammadi El Youzghi. All rights reserved
 * @author    Mohammadi El Youzghi (mo.elyouzghi@gmail.com)
 *
 * @link      https://github.com/ayrad
 *
 * @licence   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

namespace App\Issues\Application\Command;

use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Repository\IssueRepositoryInterface;
use App\Projects\Domain\Repository\ProjectRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

class AddIssueCommandHandler implements CommandHandlerInterface
{
    /**
     * @var IssueRepositoryInterface
     */
    private IssueRepositoryInterface $issueRepo;

    /**
     * @var ProjectRepositoryInterface
     */
    private ProjectRepositoryInterface $projectRepo;

    public function __construct(IssueRepositoryInterface $issueRepo, ProjectRepositoryInterface $projectRepo)
    {
        $this->issueRepo = $issueRepo;
        $this->projectRepo = $projectRepo;
    }

    public function __invoke(AddIssueCommand $command)
    {
        $this->projectRepo->isProjectTokenValidOrThrow($command->getProjectId(), $command->getProjectToken());

        $issue = Issue::create($command->getId(), $command->getProjectId(), $command->getRequest(), $command->getException(), $command->getTags());
        $this->issueRepo->save($issue);
    }
}
