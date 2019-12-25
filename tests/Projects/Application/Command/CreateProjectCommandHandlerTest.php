<?php

declare(strict_types=1);

namespace Tests\Projects\Application\Command;

use App\Projects\Application\Command\CreateProjectCommand;
use App\Projects\Application\Command\CreateProjectCommandHandler;
use App\Projects\Domain\Model\Project;
use App\Projects\Domain\Model\ProjectId;
use App\Projects\Domain\Model\ProjectName;
use App\Projects\Domain\Model\ProjectUrl;
use App\Projects\Domain\Repository\ProjectRepositoryInterface;
use PHPUnit\Framework\TestCase;

class CreateProjectCommandHandlerTest extends TestCase
{
    public function testCreateProject()
    {
        $id = uuid_create(UUID_TYPE_RANDOM);
        $name = 'Cool project';
        $url = 'https://coolproject.dev';

        $command = new CreateProjectCommand($id, $name, $url);
        $repoMock = $this->createMock(ProjectRepositoryInterface::class);
        $repoMock->expects($this->once())
            ->method('save')
            ->with(Project::create(ProjectId::fromString($id), ProjectName::fromString($name), ProjectUrl::fromString($url)));

        $handler = new CreateProjectCommandHandler($repoMock);
        $handler->__invoke($command);
    }
}