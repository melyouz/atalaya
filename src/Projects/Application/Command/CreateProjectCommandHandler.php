<?php

declare(strict_types=1);

namespace App\Projects\Application\Command;

use App\Projects\Domain\Model\Project;
use App\Projects\Domain\Repository\ProjectRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

class CreateProjectCommandHandler implements CommandHandlerInterface
{
    private ProjectRepositoryInterface $projectRepo;

    public function __construct(ProjectRepositoryInterface $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    public function __invoke(CreateProjectCommand $command)
    {
        $project = Project::create($command->getId(), $command->getName(), $command->getUrl());

        $this->projectRepo->save($project);
    }
}
