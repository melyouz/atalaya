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

namespace App\Issues\Application\Command;

use App\Issues\Domain\Model\Exception;
use App\Issues\Domain\Model\ExceptionClass;
use App\Issues\Domain\Model\ExceptionMessage;
use App\Issues\Domain\Model\IssueId;
use App\Issues\Domain\Model\Request;
use App\Issues\Domain\Model\RequestMethod;
use App\Issues\Domain\Model\RequestUrl;
use App\Projects\Domain\Model\ProjectId;
use App\Projects\Domain\Model\ProjectToken;
use App\Shared\Application\Command\CommandInterface;

class AddIssueCommand implements CommandInterface
{
    /**
     * @var IssueId
     */
    private IssueId $id;
    /**
     * @var ProjectId
     */
    private ProjectId $projectId;
    /**
     * @var ProjectToken
     */
    private ProjectToken $projectToken;
    /**
     * @var Request
     */
    private Request $request;
    /**
     * @var Exception
     */
    private Exception $exception;
    /**
     * @var array
     */
    private array $tags;

    public function __construct(string $id, string $projectId, string $projectToken, string $exceptionClass, string $exceptionMessage, string $requestMethod, string $requestUrl, array $requestHeaders, array $tags)
    {
        $this->id = IssueId::fromString($id);
        $this->projectId = ProjectId::fromString($projectId);
        $this->projectToken = ProjectToken::fromString($projectToken);
        $this->request = Request::create(RequestMethod::fromString($requestMethod), RequestUrl::fromString($requestUrl), $requestHeaders);
        $this->exception = Exception::create(ExceptionClass::fromString($exceptionClass), ExceptionMessage::fromString($exceptionMessage));
        $this->tags = $tags;
    }

    /**
     * @return IssueId
     */
    public function getId(): IssueId
    {
        return $this->id;
    }

    /**
     * @return ProjectId
     */
    public function getProjectId(): ProjectId
    {
        return $this->projectId;
    }

    /**
     * @return ProjectToken
     */
    public function getProjectToken(): ProjectToken
    {
        return $this->projectToken;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return Exception
     */
    public function getException(): Exception
    {
        return $this->exception;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }
}
