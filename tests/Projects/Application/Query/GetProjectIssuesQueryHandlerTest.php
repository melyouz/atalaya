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

namespace Tests\Projects\Application\Query;

use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Model\Issue\IssueId;
use App\Issues\Domain\Repository\IssueRepositoryInterface;
use App\Projects\Application\Query\GetProjectIssuesQuery;
use App\Projects\Application\Query\GetProjectIssuesQueryHandler;
use App\Projects\Domain\Model\Project\ProjectId;
use PHPUnit\Framework\TestCase;

class GetProjectIssuesQueryHandlerTest extends TestCase
{
    public function testGetProject(): void
    {
        $issueId = 'c308946c-8d78-484f-bc03-c5ee31510766';
        $projectId = '70ffba47-a7e5-40bf-90fc-0542ff44d891';

        $expected = [
            new Issue(IssueId::fromString($issueId), ProjectId::fromString($projectId)),
            new Issue(IssueId::fromString($issueId), ProjectId::fromString($projectId)),
            new Issue(IssueId::fromString($issueId), ProjectId::fromString($projectId)),
        ];

        $repoMock = $this->createMock(IssueRepositoryInterface::class);
        $repoMock->expects($this->once())
            ->method('findAllByProjectId')
            ->willReturn($expected);

        $handler = new GetProjectIssuesQueryHandler($repoMock);
        $result = $handler->__invoke(new GetProjectIssuesQuery($projectId));

        $this->assertSame($expected, $result);
    }
}
