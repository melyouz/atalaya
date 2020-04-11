<?php
/**
 *
 * @copyright 2020 Mohammadi El Youzghi. All rights reserved
 * @author    Mohammadi El Youzghi (mo.elyouzghi@gmail.com)
 *
 * @link      https://github.com/ayrad
 *
 * @licence   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

namespace Tests\Projects\Application\Query;

use App\Projects\Application\Query\GetProjectQuery;
use App\Projects\Application\Query\GetProjectQueryHandler;
use App\Projects\Domain\Exception\ProjectNotFoundException;
use App\Projects\Domain\Model\Project;
use App\Projects\Domain\Model\Project\ProjectId;
use App\Projects\Domain\Model\Project\ProjectName;
use App\Projects\Domain\Model\Project\ProjectToken;
use App\Projects\Domain\Model\Project\ProjectUrl;
use App\Projects\Domain\Repository\ProjectRepositoryInterface;
use App\Users\Domain\Model\User\UserId;
use PHPUnit\Framework\TestCase;

class GetProjectQueryHandlerTest extends TestCase
{
    public function testGetProject(): void
    {
        $id = '70ffba47-a7e5-40bf-90fc-0542ff44d891';
        $name = 'Cool project';
        $url = 'https://coolproject.dev';
        $userId = '3c9ec32a-9c3a-4be1-b64d-0a0bb6ddf28f';
        $project = Project::create(ProjectId::fromString($id), ProjectName::fromString($name), ProjectUrl::fromString($url), ProjectToken::fromString('d15e6e18cd0a8ef2672e0f392368cc56'), UserId::fromString($userId));
        $repoMock = $this->createMock(ProjectRepositoryInterface::class);

        $repoMock->expects($this->once())
            ->method('get')
            ->willReturn($project);

        $handler = new GetProjectQueryHandler($repoMock);
        $result = $handler->__invoke(new GetProjectQuery($id));

        $this->assertSame($project, $result);
    }
}
