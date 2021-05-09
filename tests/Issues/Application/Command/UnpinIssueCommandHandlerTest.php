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

declare(strict_types=1);

namespace Tests\Issues\Application\Command;

use App\Issues\Application\Command\UnpinIssueCommand;
use App\Issues\Application\Command\UnpinIssueCommandHandler;
use App\Issues\Domain\Exception\IssueNotPinnedYetException;
use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Model\Issue\IssueId;
use App\Issues\Domain\Repository\IssueRepositoryInterface;
use App\Projects\Domain\Model\Project\ProjectId;
use PHPUnit\Framework\TestCase;

class UnpinIssueCommandHandlerTest extends TestCase
{
    private Issue $issue;
    private UnpinIssueCommand $command;
    private UnpinIssueCommandHandler $handler;

    public function testUnpinIssue()
    {
        $this->issue->pin();
        $this->assertTrue($this->issue->isPinned());
        $this->handler->__invoke($this->command);
        $this->assertFalse($this->issue->isPinned());
    }

    public function testIssueCannotBeUnpindWhenNotResolved()
    {
        $this->expectException(IssueNotPinnedYetException::class);
        $this->handler->__invoke($this->command);
    }

    protected function setUp(): void
    {
        $id = 'c308946c-8d78-484f-bc03-c5ee31510766';
        $projectId = '70ffba47-a7e5-40bf-90fc-0542ff44d891';
        $this->issue = new Issue(IssueId::fromString($id), ProjectId::fromString($projectId));

        $this->command = new UnpinIssueCommand($id);
        $repoMock = $this->createMock(IssueRepositoryInterface::class);
        $repoMock->expects($this->once())
            ->method('get')
            ->with(IssueId::fromString($id))
            ->willReturn($this->issue);

        $this->handler = new UnpinIssueCommandHandler($repoMock);
    }
}
