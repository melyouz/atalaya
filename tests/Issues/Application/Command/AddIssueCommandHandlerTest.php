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

use App\Issues\Application\Command\AddIssueCommand;
use App\Issues\Application\Command\AddIssueCommandHandler;
use App\Issues\Application\DTO\CodeExcerptDto;
use App\Issues\Application\DTO\CodeLineDto;
use App\Issues\Application\DTO\ExceptionDto;
use App\Issues\Application\DTO\FileDto;
use App\Issues\Application\DTO\IssueDto;
use App\Issues\Application\DTO\RequestDto;
use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Model\Issue\CodeExcerpt;
use App\Issues\Domain\Model\Issue\Exception;
use App\Issues\Domain\Model\Issue\File;
use App\Issues\Domain\Model\Issue\IssueStatus;
use App\Issues\Domain\Model\Issue\Request;
use App\Issues\Domain\Repository\IssueRepositoryInterface;
use App\Projects\Domain\Repository\ProjectRepositoryInterface;
use PHPUnit\Framework\TestCase;

class AddIssueCommandHandlerTest extends TestCase
{
    public function testAddIssue()
    {
        $id = 'c308946c-8d78-484f-bc03-c5ee31510766';
        $projectId = '70ffba47-a7e5-40bf-90fc-0542ff44d891';
        $projectToken = '6cb1e543d72163b8686401b647a2003a';
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

        $requestDto = new RequestDto($requestMethod, $requestUrl, $requestHeaders);
        $exceptionDto = new ExceptionDto($exceptionCode, $exceptionClass, $exceptionMessage);
        $fileDto = new FileDto($filePath, $fileLine);
        $codeExcerptDto = new CodeExcerptDto($excerptLang, $excerptLines);
        $issueDto = new IssueDto($requestDto, $exceptionDto, $fileDto, $codeExcerptDto, $tags);
        $command = new AddIssueCommand($id, $projectId, $projectToken, $issueDto);

        $issueRepoMock = $this->createMock(IssueRepositoryInterface::class);
        $issueRepoMock->expects($this->once())
            ->method('save')
            ->willReturnCallback(function (Issue $issue) use ($id, $projectId) {
                $this->assertEquals($id, $issue->getId()->value());
                $this->assertEquals($projectId, $issue->getProjectId()->value());
                $this->assertInstanceOf(Request::class, $issue->getRequest());
                $this->assertInstanceOf(Exception::class, $issue->getException());
                $this->assertInstanceOf(File::class, $issue->getFile());
                $this->assertInstanceOf(CodeExcerpt::class, $issue->getCodeExcerpt());
                $this->assertEquals(IssueStatus::OPEN, $issue->getStatus());
                $this->assertCount(7, $issue->getRequest()->getHeaders());
                $this->assertCount(11, $issue->getCodeExcerpt()->getLines());
                $this->assertCount(16, $issue->getTags());
            });

        $projectRepoMock = $this->createMock(ProjectRepositoryInterface::class);
        $projectRepoMock->expects($this->once())
            ->method('isProjectTokenValidOrThrow')
            ->with($projectId, $projectToken)
            ->willReturn(true);

        $handler = new AddIssueCommandHandler($issueRepoMock, $projectRepoMock);
        $handler->__invoke($command);
    }
}
