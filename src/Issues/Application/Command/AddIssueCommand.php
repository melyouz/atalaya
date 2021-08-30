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

namespace App\Issues\Application\Command;

use App\Issues\Application\DTO\IssueDto;
use App\Issues\Domain\Model\Issue\IssueId;
use App\Projects\Domain\Model\Project\ProjectId;
use App\Projects\Domain\Model\Project\ProjectToken;
use App\Shared\Application\Command\CommandInterface;

class AddIssueCommand implements CommandInterface
{
    private IssueId $id;

    private ProjectId $projectId;

    private ProjectToken $projectToken;

    private IssueDto $issueDto;

    public function __construct(string $id, string $projectId, string $projectToken, IssueDto $issueDto)
    {
        $this->id = IssueId::fromString($id);
        $this->projectId = ProjectId::fromString($projectId);
        $this->projectToken = ProjectToken::fromString($projectToken);
        $this->issueDto = $issueDto;
    }

    public function getId(): IssueId
    {
        return $this->id;
    }

    public function getProjectId(): ProjectId
    {
        return $this->projectId;
    }

    public function getProjectToken(): ProjectToken
    {
        return $this->projectToken;
    }

    public function getIssueDto(): IssueDto
    {
        return $this->issueDto;
    }
}
