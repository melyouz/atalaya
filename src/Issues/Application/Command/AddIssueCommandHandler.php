<?php

namespace App\Issues\Application\Command;

use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Repository\IssueRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

class AddIssueCommandHandler implements CommandHandlerInterface
{
    /**
     * @var IssueRepositoryInterface
     */
    private IssueRepositoryInterface $issueRepo;

    public function __construct(IssueRepositoryInterface $issueRepo)
    {
        $this->issueRepo = $issueRepo;
    }

    public function __invoke(AddIssueCommand $command)
    {
        $issue = Issue::create($command->getId(), $command->getProjectId(), $command->getRequest(), $command->getException(), $command->getTags());

        $this->issueRepo->save($issue);
    }
}
