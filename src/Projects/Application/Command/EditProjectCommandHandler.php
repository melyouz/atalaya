<?php

declare(strict_types=1);

namespace App\Projects\Application\Command;

use App\Projects\Domain\Repository\ProjectRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

class EditProjectCommandHandler implements CommandHandlerInterface
{
    private ProjectRepositoryInterface $projectRepo;

    public function __construct(ProjectRepositoryInterface $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    public function __invoke(EditProjectCommand $command)
    {
        $project = $this->projectRepo->get($command->getId());

        $project->changeName($command->getName());
        $project->changeUrl($command->getUrl());

        $this->projectRepo->save($project);
    }
}
