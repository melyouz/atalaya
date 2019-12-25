<?php

declare(strict_types=1);

namespace Tests\Issues\Application\Command;

use App\Issues\Application\Command\AddIssueCommand;
use App\Issues\Application\Command\AddIssueCommandHandler;
use App\Issues\Domain\Model\Exception;
use App\Issues\Domain\Model\ExceptionClass;
use App\Issues\Domain\Model\ExceptionMessage;
use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Model\IssueId;
use App\Issues\Domain\Model\Request;
use App\Issues\Domain\Model\RequestMethod;
use App\Issues\Domain\Model\RequestUrl;
use App\Issues\Domain\Repository\IssueRepositoryInterface;
use App\Projects\Domain\Model\ProjectId;
use PHPUnit\Framework\TestCase;

class AddIssueCommandHandlerTest extends TestCase
{
    public function testAddIssue()
    {
        $id = uuid_create(UUID_TYPE_RANDOM);
        $projectId = uuid_create(UUID_TYPE_RANDOM);
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
