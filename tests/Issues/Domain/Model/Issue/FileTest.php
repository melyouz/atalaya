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
use App\Issues\Domain\Model\Issue\File;
use App\Issues\Domain\Model\Issue\File\FileLine;
use App\Issues\Domain\Model\Issue\File\FilePath;
use App\Issues\Domain\Model\Issue\IssueId;
use App\Projects\Domain\Model\Project\ProjectId;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    private File $file;

    public function testHasPath(): void
    {
        $this->assertInstanceOf(FilePath::class, $this->file->getPath());
        $this->assertEquals('C:\develop\projects\Atalaya\src\Shared\Presentation\Backoffice\Controller\IndexController.php', $this->file->getPath()->value());
    }

    public function testHasLine(): void
    {
        $this->assertInstanceOf(FileLine::class, $this->file->getLine());
        $this->assertEquals(34, $this->file->getLine()->value());
    }

    protected function setUp(): void
    {
        $id = 'c308946c-8d78-484f-bc03-c5ee31510766';
        $projectId = '70ffba47-a7e5-40bf-90fc-0542ff44d891';
        $issue = new Issue(IssueId::fromString($id), ProjectId::fromString($projectId));

        $filePath = 'C:\develop\projects\Atalaya\src\Shared\Presentation\Backoffice\Controller\IndexController.php';
        $fileLine = 34;
        $this->file = new File($issue, FilePath::fromString($filePath), FileLine::fromInteger($fileLine));
    }
}
