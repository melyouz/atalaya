<?php
/**
 *
 * @copyright 2019 Mohammadi El Youzghi. All rights reserved
 * @author    Mohammadi El Youzghi (mo.elyouzghi@gmail.com)
 *
 * @link      https://github.com/ayrad
 *
 * @licence   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

declare(strict_types=1);

namespace Tests\Projects\Application\Command;

use App\Projects\Application\Command\EditProjectCommand;
use App\Projects\Application\Command\EditProjectCommandHandler;
use App\Projects\Domain\Model\Project;
use App\Projects\Domain\Model\Project\ProjectId;
use App\Projects\Domain\Model\Project\ProjectName;
use App\Projects\Domain\Model\Project\ProjectPlatform;
use App\Projects\Domain\Model\Project\ProjectToken;
use App\Projects\Domain\Model\Project\ProjectUrl;
use App\Projects\Domain\Repository\ProjectRepositoryInterface;
use App\Users\Domain\Model\User\UserId;
use PHPUnit\Framework\TestCase;

class EditProjectCommandHandlerTest extends TestCase
{
    public function testEditProject()
    {
        $id = '70ffba47-a7e5-40bf-90fc-0542ff44d891';
        $name = 'Cool project';
        $url = 'https://coolproject.dev';
        $userId = '3c9ec32a-9c3a-4be1-b64d-0a0bb6ddf28f';
        $newName = 'Cool project - modified';
        $newUrl = 'https://coolproject-v2.dev';
        $newPlatform = ProjectPlatform::SYMFONY;

        $command = new EditProjectCommand($id, $newName, $newUrl, $newPlatform);
        $repoMock = $this->createMock(ProjectRepositoryInterface::class);

        $project = new Project(ProjectId::fromString($id), ProjectName::fromString($name), ProjectUrl::fromString($url), ProjectToken::fromString('d15e6e18cd0a8ef2672e0f392368cc56'), ProjectPlatform::fromString(ProjectPlatform::PHP), UserId::fromString($userId));
        $expectedProject = clone $project;
        $expectedProject->changeName(ProjectName::fromString($newName));
        $expectedProject->changeUrl(ProjectUrl::fromString($newUrl));
        $expectedProject->changePlatform(ProjectPlatform::fromString($newPlatform));

        $repoMock->expects($this->once())
            ->method('get')
            ->with(ProjectId::fromString($id))
            ->willReturn($expectedProject);

        $repoMock->expects($this->once())
            ->method('save')
            ->with($expectedProject);

        $handler = new EditProjectCommandHandler($repoMock);
        $handler->__invoke($command);
    }
}
