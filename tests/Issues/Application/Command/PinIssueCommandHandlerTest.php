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

namespace Tests\Issues\Application\Command;

use App\Issues\Application\Command\PinIssueCommand;
use App\Issues\Application\Command\PinIssueCommandHandler;
use App\Issues\Domain\Exception\IssueAlreadyPinnedException;
use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Model\Issue\IssueId;
use App\Issues\Domain\Repository\IssueRepositoryInterface;
use App\Projects\Domain\Model\Project\ProjectId;
use PHPUnit\Framework\TestCase;

class PinIssueCommandHandlerTest extends TestCase
{
    private Issue $issue;
    private PinIssueCommand $command;
    private PinIssueCommandHandler $handler;

    public function testPinIssue()
    {
        $this->handler->__invoke($this->command);
        $this->assertTrue($this->issue->isPinned());
    }

    public function testIssueCannotBePinnedTwice()
    {
        $this->issue->pin();
        $this->expectException(IssueAlreadyPinnedException::class);
        $this->handler->__invoke($this->command);
    }

    protected function setUp(): void
    {
        $id = 'c308946c-8d78-484f-bc03-c5ee31510766';
        $projectId = '70ffba47-a7e5-40bf-90fc-0542ff44d891';
        $this->issue = new Issue(IssueId::fromString($id), ProjectId::fromString($projectId));

        $this->command = new PinIssueCommand($id);
        $repoMock = $this->createMock(IssueRepositoryInterface::class);
        $repoMock->expects($this->once())
            ->method('get')
            ->with(IssueId::fromString($id))
            ->willReturn($this->issue);

        $this->handler = new PinIssueCommandHandler($repoMock);
    }
}
