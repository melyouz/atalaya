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

use App\Projects\Application\Command\RecoverProjectCommand;
use App\Projects\Application\Command\RecoverProjectCommandHandler;
use App\Projects\Domain\Model\Project;
use App\Projects\Domain\Model\ProjectId;
use App\Projects\Domain\Model\ProjectName;
use App\Projects\Domain\Model\ProjectUrl;
use App\Projects\Domain\Repository\ProjectRepositoryInterface;
use App\Users\Domain\Model\UserId;
use PHPUnit\Framework\TestCase;

class RecoverProjectCommandHandlerTest extends TestCase
{
    public function testRecoverProject()
    {
        $id = '70ffba47-a7e5-40bf-90fc-0542ff44d891';
        $name = 'Cool project';
        $url = 'https://coolproject.dev';
        $userId = '3c9ec32a-9c3a-4be1-b64d-0a0bb6ddf28f';

        $command = new RecoverProjectCommand($id);
        $repoMock = $this->createMock(ProjectRepositoryInterface::class);

        $project = Project::create(ProjectId::fromString($id), ProjectName::fromString($name), ProjectUrl::fromString($url), UserId::fromString($userId));
        $project->archive();
        $repoMock->expects($this->once())
            ->method('get')
            ->with(ProjectId::fromString($id))
            ->willReturn($project);

        $handler = new RecoverProjectCommandHandler($repoMock);
        $handler->__invoke($command);

        $this->assertFalse($project->isArchived());
    }
}
