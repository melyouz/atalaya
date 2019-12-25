<?php

declare(strict_types=1);

namespace Tests\Projects\Application\Command;

use App\Projects\Application\Command\RecoverProjectCommand;
use App\Projects\Application\Command\RecoverProjectCommandHandler;
use App\Projects\Domain\Model\Project;
use App\Projects\Domain\Model\ProjectId;
use App\Projects\Domain\Model\ProjectName;
use App\Projects\Domain\Model\ProjectUrl;
use App\Projects\Domain\Repository\ProjectRepositoryInterface;
use PHPUnit\Framework\TestCase;

class RecoverProjectCommandHandlerTest extends TestCase
{
    public function testRecoverProject()
    {
        $id = uuid_create(UUID_TYPE_RANDOM);
        $name = 'Cool project';
        $url = 'https://coolproject.dev';

        $command = new RecoverProjectCommand($id);
        $repoMock = $this->createMock(ProjectRepositoryInterface::class);

        $project = Project::create(ProjectId::fromString($id), ProjectName::fromString($name), ProjectUrl::fromString($url));
        $repoMock->expects($this->once())
            ->method('get')
            ->with(ProjectId::fromString($id))
            ->willReturn($project);

        $handler = new RecoverProjectCommandHandler($repoMock);
        $handler->__invoke($command);

        $this->assertFalse($project->isArchived());
    }
}