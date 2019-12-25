<?php

declare(strict_types=1);

namespace App\Projects\Application\Command;

use App\Projects\Domain\Model\ProjectId;
use App\Shared\Application\Command\CommandInterface;

class ArchiveProjectCommand implements CommandInterface
{
    /**
     * @var ProjectId
     */
    private ProjectId $id;

    public function __construct(string $id)
    {
        $this->id = ProjectId::fromString($id);
    }

    /**
     * @return ProjectId
     */
    public function getId(): ProjectId
    {
        return $this->id;
    }
}
