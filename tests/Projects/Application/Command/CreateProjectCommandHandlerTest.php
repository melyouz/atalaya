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

use App\Projects\Application\Command\CreateProjectCommand;
use App\Projects\Application\Command\CreateProjectCommandHandler;
use App\Projects\Domain\Model\Project;
use App\Projects\Domain\Model\Project\ProjectId;
use App\Projects\Domain\Model\Project\ProjectName;
use App\Projects\Domain\Model\Project\ProjectToken;
use App\Projects\Domain\Model\Project\ProjectUrl;
use App\Projects\Domain\Repository\ProjectRepositoryInterface;
use App\Shared\Application\Util\TokenGenerator;
use App\Users\Domain\Model\User\UserId;
use PHPUnit\Framework\TestCase;

class CreateProjectCommandHandlerTest extends TestCase
{
    public function testCreateProject()
    {
        $id = '70ffba47-a7e5-40bf-90fc-0542ff44d891';
        $name = 'Cool project';
        $url = 'https://coolproject.dev';
        $userId = '3c9ec32a-9c3a-4be1-b64d-0a0bb6ddf28f';

        $command = new CreateProjectCommand($id, $name, $url, $userId);
        $repoMock = $this->createMock(ProjectRepositoryInterface::class);
        $repoMock->expects($this->once())
            ->method('save')
            ->with(Project::create(ProjectId::fromString($id), ProjectName::fromString($name), ProjectUrl::fromString($url), ProjectToken::fromString('d15e6e18cd0a8ef2672e0f392368cc56'), UserId::fromString($userId)));

        $tokenGeneratorMock = $this->createMock(TokenGenerator::class);
        $tokenGeneratorMock->expects($this->once())
            ->method('md5RandomToken')
            ->willReturn('d15e6e18cd0a8ef2672e0f392368cc56');

        $handler = new CreateProjectCommandHandler($repoMock, $tokenGeneratorMock);
        $handler->__invoke($command);
    }
}
