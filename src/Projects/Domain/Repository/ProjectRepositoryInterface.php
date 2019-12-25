<?php

declare(strict_types=1);

namespace App\Projects\Domain\Repository;

use App\Projects\Domain\Exception\ProjectNotFoundException;
use App\Projects\Domain\Model\Project;
use App\Projects\Domain\Model\ProjectId;

interface ProjectRepositoryInterface
{
    /**
     * @param ProjectId $id
     * @return Project
     * @throws ProjectNotFoundException
     */
    public function get(ProjectId $id): Project;

    /**
     * @param Project $project
     */
    public function save(Project $project): void;
}
