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

namespace Tests\Issues\Application\Query;

use App\Issues\Application\Query\GetIssueQuery;
use App\Issues\Application\Query\GetIssueQueryHandler;
use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Model\Issue\IssueId;
use App\Issues\Domain\Repository\IssueRepositoryInterface;
use App\Projects\Domain\Model\Project\ProjectId;
use PHPUnit\Framework\TestCase;

class GetIssueQueryHandlerTest extends TestCase
{
    public function testGetProject(): void
    {
        $id = 'c308946c-8d78-484f-bc03-c5ee31510766';
        $projectId = '70ffba47-a7e5-40bf-90fc-0542ff44d891';
        $issue = new Issue(IssueId::fromString($id), ProjectId::fromString($projectId));

        $repoMock = $this->createMock(IssueRepositoryInterface::class);
        $repoMock->expects($this->once())
            ->method('get')
            ->willReturn($issue);

        $handler = new GetIssueQueryHandler($repoMock);
        $result = $handler->__invoke(new GetIssueQuery($id));

        $this->assertSame($issue, $result);
    }
}
