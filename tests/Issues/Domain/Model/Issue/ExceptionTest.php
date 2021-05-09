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

namespace Tests\Issues\Domain\Model\Issue;

use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Model\Issue\Exception;
use App\Issues\Domain\Model\Issue\Exception\ExceptionClass;
use App\Issues\Domain\Model\Issue\Exception\ExceptionCode;
use App\Issues\Domain\Model\Issue\Exception\ExceptionMessage;
use App\Issues\Domain\Model\Issue\IssueId;
use App\Projects\Domain\Model\Project\ProjectId;
use PHPUnit\Framework\TestCase;

class ExceptionTest extends TestCase
{
    /**
     * @var Exception
     */
    private Exception $exception;

    public function testHasCode(): void
    {
        $this->assertInstanceOf(ExceptionCode::class, $this->exception->getCode());
        $this->assertEquals('xx', $this->exception->getCode()->value());
    }

    public function testHasClass(): void
    {
        $this->assertInstanceOf(ExceptionClass::class, $this->exception->getClass());
        $this->assertEquals('App\Whatever\Class', $this->exception->getClass()->value());
    }

    public function testClassName(): void
    {
        $this->assertEquals('Class', $this->exception->getClassName());
    }

    public function testHasMessage(): void
    {
        $this->assertInstanceOf(ExceptionMessage::class, $this->exception->getMessage());
        $this->assertEquals('Error: Call to undefined function notExistingFunction()', $this->exception->getMessage());
    }

    protected function setUp(): void
    {
        $id = 'c308946c-8d78-484f-bc03-c5ee31510766';
        $projectId = '70ffba47-a7e5-40bf-90fc-0542ff44d891';
        $issue = new Issue(IssueId::fromString($id), ProjectId::fromString($projectId));

        $exceptionCode = 'xx';
        $exceptionClass = 'App\Whatever\Class';
        $exceptionMessage = 'Error: Call to undefined function notExistingFunction()';
        $this->exception = new Exception($issue, ExceptionCode::fromString($exceptionCode), ExceptionClass::fromString($exceptionClass), ExceptionMessage::fromString($exceptionMessage));
    }
}
