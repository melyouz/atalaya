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

use App\Issues\Application\Command\AddIssueCommand;
use App\Issues\Application\Command\AddIssueCommandHandler;
use App\Issues\Domain\Model\Issue\Exception;
use App\Issues\Domain\Model\Issue\Exception\ExceptionClass;
use App\Issues\Domain\Model\Issue\Exception\ExceptionMessage;
use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Model\Issue\IssueId;
use App\Issues\Domain\Model\Issue\Request;
use App\Issues\Domain\Model\Issue\Request\RequestMethod;
use App\Issues\Domain\Model\Issue\Request\RequestUrl;
use App\Issues\Domain\Repository\IssueRepositoryInterface;
use App\Projects\Domain\Model\Project\ProjectId;
use PHPUnit\Framework\TestCase;

class AddIssueCommandHandlerTest extends TestCase
{
    public function testAddIssue()
    {
        $id = 'c308946c-8d78-484f-bc03-c5ee31510766';
        $projectId = '70ffba47-a7e5-40bf-90fc-0542ff44d891';
        $exceptionClass = 'App\Whatever\Class';
        $exceptionMessage = 'Error: Call to undefined function notExistingFunction()';
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

        $command = new AddIssueCommand($id, $projectId, $exceptionClass, $exceptionMessage, $requestMethod, $requestUrl, $requestHeaders, $tags);
        $expectedIssue = Issue::create(IssueId::fromString($id),
            ProjectId::fromString($projectId),
            Request::create(RequestMethod::fromString($requestMethod), RequestUrl::fromString($requestUrl), $requestHeaders),
            Exception::create(ExceptionClass::fromString($exceptionClass), ExceptionMessage::fromString($exceptionMessage))
            , $tags
        );

        $repoMock = $this->createMock(IssueRepositoryInterface::class);
        $repoMock->expects($this->once())
            ->method('save')
            ->with($expectedIssue);

        $handler = new AddIssueCommandHandler($repoMock);
        $handler->__invoke($command);
    }
}
