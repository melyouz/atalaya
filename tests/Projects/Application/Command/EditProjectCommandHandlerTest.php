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
use App\Projects\Domain\Model\ProjectId;
use App\Projects\Domain\Model\ProjectName;
use App\Projects\Domain\Model\ProjectUrl;
use App\Projects\Domain\Repository\ProjectRepositoryInterface;
use PHPUnit\Framework\TestCase;

class EditProjectCommandHandlerTest extends TestCase
{
    public function testEditProject()
    {
        $id = uuid_create(UUID_TYPE_RANDOM);
        $name = 'Cool project';
        $url = 'https://coolproject.dev';
        $newName = 'Cool project - modified';
        $newUrl = 'https://coolproject-v2.dev';

        $command = new EditProjectCommand($id, $newName, $newUrl);
        $repoMock = $this->createMock(ProjectRepositoryInterface::class);

        $repoMock->expects($this->once())
            ->method('get')
            ->with(ProjectId::fromString($id))
            ->willReturn(Project::create(ProjectId::fromString($id), ProjectName::fromString($name), ProjectUrl::fromString($url)));

        $repoMock->expects($this->once())
            ->method('save')
            ->with(Project::create(ProjectId::fromString($id), ProjectName::fromString($newName), ProjectUrl::fromString($newUrl)));

        $handler = new EditProjectCommandHandler($repoMock);
        $handler->__invoke($command);
    }
}
