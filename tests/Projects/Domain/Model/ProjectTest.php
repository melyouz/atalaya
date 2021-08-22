<?php
/*
 *
 * @copyright 2019-present Mohammadi El Youzghi. All rights reserved
 * @author    Mohammadi El Youzghi (mo.elyouzghi@gmail.com)
 *
 * @link      https://github.com/melyouz
 *
 * @licence   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

namespace Tests\Projects\Domain\Model;

use App\Projects\Domain\Model\Project;
use App\Projects\Domain\Model\Project\ProjectId;
use App\Projects\Domain\Model\Project\ProjectName;
use App\Projects\Domain\Model\Project\ProjectPlatform;
use App\Projects\Domain\Model\Project\ProjectToken;
use App\Projects\Domain\Model\Project\ProjectUrl;
use App\Users\Domain\Model\User\UserId;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ProjectTest extends TestCase
{
    private Project $project;

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

    public function testCreatedProjectHasToken(): void
    {
        $this->assertInstanceOf(ProjectToken::class, $this->project->getToken());
        $this->assertNotEmpty($this->project->getToken()->value());
    }

    public function testCreatedProjectIsNotArchived(): void
    {
        $this->assertFalse($this->project->isArchived());
    }

    public function testProjectHasCreatedAt(): void
    {
        $this->assertInstanceOf(DateTimeImmutable::class, $this->project->getCreatedAt());
    }

    protected function setUp(): void
    {
        /*
         * public function __construct(ProjectId $id, ProjectName $name, ProjectUrl $url, ProjectToken $token, ProjectPlatform $platform, UserId $userId)
    {
        $this->id = $id->value();
        $this->name = $name->value();
        $this->url = $url->value();
        $this->token = $token->value();
        $this->platform = $platform->value();
        $this->userId = $userId->value();
        $this->createdAt = new DateTimeImmutable();
    }
         */
        $this->project = new Project(
            ProjectId::fromString('9f6150ab-29b0-4523-8421-644f42487e47'),
            ProjectName::fromString('Awesome project'),
            ProjectUrl::fromString('https://awesome-project.dev'),
            ProjectToken::fromString('d15e6e18cd0a8ef2672e0f392368cc56'),
            ProjectPlatform::fromString(ProjectPlatform::PHP),
            UserId::fromString('3c9ec32a-9c3a-4be1-b64d-0a0bb6ddf28f')
        );
    }
}
