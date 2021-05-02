<?php
/*
 *
 * @copyright 2021 Mohammadi El Youzghi. All rights reserved
 * @author    Mohammadi El Youzghi (mo.elyouzghi@gmail.com)
 *
 * @link      https://github.com/ayrad
 *
 * @licence   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

namespace Tests\Issues\Domain\Model\Issue;

use App\Issues\Application\DTO\CodeLineDto;
use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Model\Issue\CodeExcerpt;
use App\Issues\Domain\Model\Issue\CodeExcerpt\CodeExcerptCodeLine;
use App\Issues\Domain\Model\Issue\CodeExcerpt\CodeExcerptId;
use App\Issues\Domain\Model\Issue\CodeExcerpt\CodeExcerptLanguage;
use App\Issues\Domain\Model\Issue\File;
use App\Issues\Domain\Model\Issue\File\FileLine;
use App\Issues\Domain\Model\Issue\File\FilePath;
use App\Issues\Domain\Model\Issue\IssueId;
use App\Issues\Domain\Model\Issue\Request;
use App\Issues\Domain\Model\Issue\Request\RequestMethod;
use App\Issues\Domain\Model\Issue\Request\RequestUrl;
use App\Projects\Domain\Model\Project\ProjectId;
use PHPUnit\Framework\TestCase;

class CodeExcerptTest extends TestCase
{
    private CodeExcerpt $excerpt;

    protected function setUp(): void
    {
        $id = 'c308946c-8d78-484f-bc03-c5ee31510766';
        $projectId = '70ffba47-a7e5-40bf-90fc-0542ff44d891';
        $issue = new Issue(IssueId::fromString($id), ProjectId::fromString($projectId));

        $excerptId = uuid_create(UUID_TYPE_RANDOM);
        $excerptLang = 'php';
        $excerptLines = [
            ['line' => 29, 'content' => '        $this->twig = $twig;', 'selected' => false],
            ['line' => 30, 'content' => '    }', 'selected' => false],
            ['line' => 31, 'content' => '', 'selected' => false],
            ['line' => 32, 'content' => '    public function __invoke(): Response", ', 'selected' => false],
            ['line' => 33, 'content' => '    {', 'selected' => false],
            ['line' => 34, 'content' => "        throw new \\RuntimeException('test exception');", 'selected' =>  true],
            ['line' => 35, 'content' => '', 'selected' => false],
            ['line' => 36, 'content' => "        \$content = \$this->twig->render('Backoffice/index.html.twig');", 'selected' => false],
            ['line' => 37, 'content' => '', 'selected' => false],
            ['line' => 38, 'content' => '        return new Response($content);', 'selected' => false],
            ['line' => 39, 'content' => '    }', 'selected' => false],
        ];

        $this->excerpt = new CodeExcerpt(CodeExcerptId::fromString($excerptId), $issue, CodeExcerptLanguage::fromString($excerptLang), $excerptLines);
    }

    public function testHasId(): void
    {
        $this->assertInstanceOf(CodeExcerptId::class, $this->excerpt->getId());
    }

    public function testHasLang(): void
    {
        $this->assertInstanceOf(CodeExcerptLanguage::class, $this->excerpt->getLang());
        $this->assertEquals('php', $this->excerpt->getLang()->value());
    }

    public function testHasLines(): void
    {
        $this->assertContainsOnlyInstancesOf(CodeExcerptCodeLine::class, $this->excerpt->getLines());
        $this->assertCount(11, $this->excerpt->getLines());

        $firstLine = $this->excerpt->getLines()[0];
        $this->assertEquals(29, $firstLine->getLine());
        $this->assertEquals('        $this->twig = $twig;', $firstLine->getContent());
        $this->assertFalse($firstLine->isSelected());
    }
}
