<?php

declare(strict_types=1);

namespace Tests\Projects\Application\Command;

use App\Projects\Application\Command\ArchiveProjectCommand;
use App\Projects\Application\Command\ArchiveProjectCommandHandler;
use App\Projects\Domain\Exception\ProjectAlreadyArchivedException;
use App\Projects\Domain\Model\Project;
use App\Projects\Domain\Model\ProjectId;
use App\Projects\Domain\Model\ProjectName;
use App\Projects\Domain\Model\ProjectUrl;
use App\Projects\Domain\Repository\ProjectRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ArchiveProjectCommandHandlerTest extends TestCase
{
    private Project $project;
    private ArchiveProjectCommand $command;
    private ArchiveProjectCommandHandler $handler;

    protected function setUp()
    {
        $id = uuid_create(UUID_TYPE_RANDOM);
        $name = 'Cool project';
        $url = 'https://coolproject.dev';

        $this->project = Project::create(ProjectId::fromString($id), ProjectName::fromString($name), ProjectUrl::fromString($url));
        $this->command = new ArchiveProjectCommand($id);
        $repoMock = $this->createMock(ProjectRepositoryInterface::class);
        $repoMock->expects($this->once())
            ->method('get')
            ->with(ProjectId::fromString($id))
            ->willReturn($this->project);

        $this->handler = new ArchiveProjectCommandHandler($repoMock);
    }

    public function testArchiveProject()
    {
        $this->handler->__invoke($this->command);
        $this->assertTrue($this->project->isArchived());
    }

    public function testProjectCannotBeArchivedTwice()
    {
        $this->project->archive();
        $this->expectException(ProjectAlreadyArchivedException::class);
        $this->handler->__invoke($this->command);
    }
}