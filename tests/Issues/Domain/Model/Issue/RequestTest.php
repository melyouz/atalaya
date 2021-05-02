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

use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Model\Issue\IssueId;
use App\Issues\Domain\Model\Issue\Request;
use App\Issues\Domain\Model\Issue\Request\RequestMethod;
use App\Issues\Domain\Model\Issue\Request\RequestUrl;
use App\Projects\Domain\Model\Project\ProjectId;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    /**
     * @var Request
     */
    private Request $request;

    protected function setUp(): void
    {
        $id = 'c308946c-8d78-484f-bc03-c5ee31510766';
        $projectId = '70ffba47-a7e5-40bf-90fc-0542ff44d891';
        $issue = new Issue(IssueId::fromString($id), ProjectId::fromString($projectId));

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
        $this->request = new Request($issue, RequestMethod::fromString($requestMethod), RequestUrl::fromString($requestUrl), $requestHeaders);
    }

    public function testHasMethod(): void
    {
        $this->assertInstanceOf(RequestMethod::class, $this->request->getMethod());
        $this->assertEquals('GET', $this->request->getMethod()->value());
    }

    public function testHasUrl(): void
    {
        $this->assertInstanceOf(RequestUrl::class, $this->request->getUrl());
        $this->assertEquals('https://whatever-project.dev/api/products/c74ddda3-82ed-431c-8109-980aa25e2232', $this->request->getUrl()->value());
    }

    public function testHasHeaders(): void
    {
        $this->assertEquals([
            'Content-Type' => 'application/json',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36',
            'Accept' => '*/*',
            'Cache-Control' => 'no-cache',
            'Host' => 'whatever-project.dev',
            'Accept-Encoding' => 'gzip, deflate',
            'Connection' => 'keep-alive',
        ], $this->request->getHeaders());
    }
}
