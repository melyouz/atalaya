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

use App\Issues\Domain\Model\Issue\Exception;
use App\Issues\Domain\Model\Issue\IssueId;
use App\Issues\Domain\Model\Issue\Request;
use App\Projects\Domain\Model\Project\ProjectId;
use App\Projects\Domain\Model\Project\ProjectToken;
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

    public function __construct(string $id, string $projectId, string $projectToken, Exception $exception, Request $request, array $tags)
    {
        $this->id = IssueId::fromString($id);
        $this->projectId = ProjectId::fromString($projectId);
        $this->projectToken = ProjectToken::fromString($projectToken);
        $this->exception = $exception;
        $this->request = $request;
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
