<?php

declare(strict_types=1);

namespace App\Projects\Application\Command;

use App\Projects\Domain\Repository\ProjectRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

class ArchiveProjectCommandHandler implements CommandHandlerInterface
{
    private ProjectRepositoryInterface $projectRepo;

    public function __construct(ProjectRepositoryInterface $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    public function __invoke(ArchiveProjectCommand $command)
    {
        $project = $this->projectRepo->get($command->getId());
        $project->archive();

        $this->projectRepo->save($project);
    }
}
