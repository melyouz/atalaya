<?php

namespace Tests\Projects\Domain\Model;

use App\Projects\Domain\Model\Project;
use App\Projects\Domain\Model\ProjectId;
use App\Projects\Domain\Model\ProjectName;
use App\Projects\Domain\Model\ProjectUrl;
use PHPUnit\Framework\TestCase;

class ProjectTest extends TestCase
{
    private Project $project;

    protected function setUp(): void
    {
        $this->project = Project::create(
            ProjectId::fromString('9f6150ab-29b0-4523-8421-644f42487e47'),
            ProjectName::fromString('Awesome project'),
            ProjectUrl::fromString('https://awesome-project.dev')
        );
    }

    public function testCreatedProjectHasId(): void
    {
        $this->assertInstanceOf(ProjectId::class, $this->project->getId());
        $this->assertEquals('9f6150ab-29b0-4523-8421-644f42487e47', $this->project->getId()->value());
    }

    public function testCreatedProjectHasName(): void
    {
        $this->assertInstanceOf(ProjectName::class, $this->project->getName());
        $this->assertEquals('Awesome project', $this->project->getName()->value());
    }

    public function testCreatedProjectHasUrl(): void
    {
        $this->assertInstanceOf(ProjectUrl::class, $this->project->getUrl());
        $this->assertEquals('https://awesome-project.dev', $this->project->getUrl()->value());
    }

    public function testCreatedProjectIsNotArchived(): void
    {
        $this->assertFalse($this->project->isArchived());
    }
}