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

namespace Tests\Issues\Domain\Model;

use App\Issues\Application\DTO\CodeExcerptDto;
use App\Issues\Application\DTO\CodeLineDto;
use App\Issues\Domain\Exception\IssueCodeExcerptRequired;
use App\Issues\Domain\Exception\IssueExceptionRequired;
use App\Issues\Domain\Exception\IssueFileRequired;
use App\Issues\Domain\Exception\IssueMustBeDraft;
use App\Issues\Domain\Exception\IssueRequestRequired;
use App\Issues\Domain\Exception\TagNotFoundException;
use App\Issues\Domain\Model\Issue\CodeExcerpt\CodeExcerptId;
use App\Issues\Domain\Model\Issue\CodeExcerpt\CodeExcerptLanguage;
use App\Issues\Domain\Model\Issue\Exception;
use App\Issues\Domain\Model\Issue\Exception\ExceptionClass;
use App\Issues\Domain\Model\Issue\Exception\ExceptionCode;
use App\Issues\Domain\Model\Issue\Exception\ExceptionMessage;
use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Model\Issue\File\FileLine;
use App\Issues\Domain\Model\Issue\File\FilePath;
use App\Issues\Domain\Model\Issue\IssueId;
use App\Issues\Domain\Model\Issue\Request;
use App\Issues\Domain\Model\Issue\Request\RequestMethod;
use App\Issues\Domain\Model\Issue\Request\RequestUrl;
use App\Issues\Domain\Model\Issue\Tag\TagName;
use App\Projects\Domain\Model\Project\ProjectId;
use PHPUnit\Framework\TestCase;

class IssueTest extends TestCase
{
    private Issue $issue;
    private Issue $issueWithoutRequest;
    private Issue $issueWithoutException;
    private Issue $issueWithoutFile;
    private Issue $issueWithoutExcerpt;

    protected function setUp(): void
    {
        $id = 'c308946c-8d78-484f-bc03-c5ee31510766';
        $projectId = '70ffba47-a7e5-40bf-90fc-0542ff44d891';
        $exceptionCode = 'xx';
        $exceptionClass = 'App\Whatever\Class';
        $exceptionMessage = 'Error: Call to undefined function notExistingFunction()';
        $filePath = 'C:\develop\projects\Atalaya\src\Shared\Presentation\Backoffice\Controller\IndexController.php';
        $fileLine = 34;
        $excerptLang = 'php';
        $excerptLines = [
            new CodeLineDto(29, '        $this->twig = $twig;', false),
            new CodeLineDto(30, '    }', false),
            new CodeLineDto(31, '', false),
            new CodeLineDto(32, '    public function __invoke(): Response", ', false),
            new CodeLineDto(33, '    {', false),
            new CodeLineDto(34, "        throw new \\RuntimeException('test exception');", true),
            new CodeLineDto(35, '', false),
            new CodeLineDto(36, "        \$content = \$this->twig->render('Backoffice/index.html.twig');", false),
            new CodeLineDto(37, '', false),
            new CodeLineDto(38, '        return new Response($content);', false),
            new CodeLineDto(39, '    }', false),
        ];
        $requestMethod = 'GET';
        $requestUrl = 'https://whatever-project.dev/api/products/c74ddda3-82ed-431c-8109-980aa25e2232';
        $requestHeaders = [
            'Content-Type' => 'application/json',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36',
            'Accept' => '*/*',
            'Cache-Control' => 'no-cache',
            'Host' => 'whatever-project.dev',
            'Accept-Encoding' => 'gzip, deflate',
            'Connection' => 'keep-alive',
        ];
        $tags = [
            'url' => $requestUrl,
            'browser' => 'Chrome 78.0.3904',
            'browser.name' => 'Chrome',
            'browser.version' => '78.0.3904',
            'runtime' => 'php 7.4.0',
            'runtime.name' => 'php',
            'runtime.version' => '7.4.0',
            'os' => 'Windows NT 10.0',
            'os.name' => 'Windows NT',
            'os.version' => '10.0 (build 18363 (Windows 10))',
            'os.kernel_version' => 'Windows NT Mohammadi-PC 10.0 build 18363 (Windows 10) AMD64',
            'client_os.name' => 'Windows 10',
            'client_os.version' => '',
            'environment' => 'dev',
            'server_name' => 'Mohammadi-PC',
            'level' => 'error',
        ];


        $issueId = IssueId::fromString($id);
        $projectId = ProjectId::fromString($projectId);
        $excerptId = uuid_create(UUID_TYPE_RANDOM);
        $excerptDto = new CodeExcerptDto($excerptLang, $excerptLines);

        $issue = new Issue($issueId, $projectId, $tags);
        $issue->addRequest(RequestMethod::fromString($requestMethod), RequestUrl::fromString($requestUrl), $requestHeaders);
        $issue->addException(ExceptionCode::fromString($exceptionCode), ExceptionClass::fromString($exceptionClass), ExceptionMessage::fromString($exceptionMessage));
        $issue->addFile(FilePath::fromString($filePath), FileLine::fromInteger($fileLine));
        $issue->addCodeExcerpt(CodeExcerptId::fromString($excerptId), CodeExcerptLanguage::fromString($excerptDto->lang), $excerptDto->linesToArray());
        $issue->open();

        $this->issue = $issue;

        $this->issueWithoutRequest =  new Issue($issueId, $projectId, $tags);
        $this->issueWithoutRequest->addException(ExceptionCode::fromString($exceptionCode), ExceptionClass::fromString($exceptionClass), ExceptionMessage::fromString($exceptionMessage));
        $this->issueWithoutRequest->addFile(FilePath::fromString($filePath), FileLine::fromInteger($fileLine));
        $this->issueWithoutRequest->addCodeExcerpt(CodeExcerptId::fromString($excerptId), CodeExcerptLanguage::fromString($excerptDto->lang), $excerptDto->linesToArray());

        $this->issueWithoutException = new Issue($issueId, $projectId, $tags);
        $this->issueWithoutException->addRequest(RequestMethod::fromString($requestMethod), RequestUrl::fromString($requestUrl), $requestHeaders);
        $this->issueWithoutException->addFile(FilePath::fromString($filePath), FileLine::fromInteger($fileLine));
        $this->issueWithoutException->addCodeExcerpt(CodeExcerptId::fromString($excerptId), CodeExcerptLanguage::fromString($excerptDto->lang), $excerptDto->linesToArray());

        $this->issueWithoutFile = new Issue($issueId, $projectId, $tags);$this->issueWithoutException->addRequest(RequestMethod::fromString($requestMethod), RequestUrl::fromString($requestUrl), $requestHeaders);
        $this->issueWithoutFile->addRequest(RequestMethod::fromString($requestMethod), RequestUrl::fromString($requestUrl), $requestHeaders);
        $this->issueWithoutFile->addException(ExceptionCode::fromString($exceptionCode), ExceptionClass::fromString($exceptionClass), ExceptionMessage::fromString($exceptionMessage));
        $this->issueWithoutFile->addCodeExcerpt(CodeExcerptId::fromString($excerptId), CodeExcerptLanguage::fromString($excerptDto->lang), $excerptDto->linesToArray());

        $this->issueWithoutExcerpt = new Issue($issueId, $projectId, $tags);
        $this->issueWithoutExcerpt->addRequest(RequestMethod::fromString($requestMethod), RequestUrl::fromString($requestUrl), $requestHeaders);
        $this->issueWithoutExcerpt->addException(ExceptionCode::fromString($exceptionCode), ExceptionClass::fromString($exceptionClass), ExceptionMessage::fromString($exceptionMessage));
        $this->issueWithoutExcerpt->addFile(FilePath::fromString($filePath), FileLine::fromInteger($fileLine));
    }

    public function testHasId(): void
    {
        $this->assertInstanceOf(IssueId::class, $this->issue->getId());
        $this->assertEquals('c308946c-8d78-484f-bc03-c5ee31510766', $this->issue->getId()->value());
    }

    public function testRequestIsSet(): void
    {
        $this->assertInstanceOf(Request::class, $this->issue->getRequest());
    }

    public function testExceptionIsSet(): void
    {
        $this->assertInstanceOf(Exception::class, $this->issue->getException());
    }

    public function testTagsAreSet(): void
    {
        $this->assertIsArray($this->issue->getTags());
        $this->assertCount(16, $this->issue->getTags());
    }

    public function testTagNameIsSet(): void
    {
        $this->assertTrue($this->issue->hasTag(TagName::fromString('browser')));
    }

    public function testTagValueIsSet(): void
    {
        $this->assertEquals('Chrome 78.0.3904', $this->issue->getTagValue(TagName::fromString('browser'))->value());
    }

    public function testTagNotFound(): void
    {
        $this->expectException(TagNotFoundException::class);
        $this->issue->getTagValue(TagName::fromString('nonExistingTag'));
    }

    public function testHasSeenAt(): void
    {
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->issue->getSeenAt());
    }

    public function testCannotOpenNonDraftIssue(): void
    {
        $this->expectException(IssueMustBeDraft::class);
        $this->issue->open();
    }

    public function testCannotOpenIssueWithoutRequest(): void
    {
        $this->expectException(IssueRequestRequired::class);
        $this->issueWithoutRequest->open();
    }

    public function testCannotOpenIssueWithoutException(): void
    {
        $this->expectException(IssueExceptionRequired::class);
        $this->issueWithoutException->open();
    }

    public function testCannotOpenIssueWithoutFile(): void
    {
        $this->expectException(IssueFileRequired::class);
        $this->issueWithoutFile->open();
    }

    public function testCannotOpenIssueWithoutCodeExcerpt(): void
    {
        $this->expectException(IssueCodeExcerptRequired::class);
        $this->issueWithoutExcerpt->open();
    }
}
