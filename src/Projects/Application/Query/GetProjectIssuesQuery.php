<?php
/**
 *
 * @copyright 2020 Mohammadi El Youzghi. All rights reserved
 * @author    Mohammadi El Youzghi (mo.elyouzghi@gmail.com)
 *
 * @link      https://github.com/ayrad
 *
 * @licence   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

declare(strict_types=1);

namespace App\Projects\Application\Query;

use App\Projects\Domain\Model\Project\ProjectId;
use App\Shared\Application\Query\QueryInterface;

class GetProjectIssuesQuery implements QueryInterface
{
    /**
     * @var ProjectId
     */
    private ProjectId $projectId;

    public function __construct(string $projectId)
    {
        $this->projectId = ProjectId::fromString($projectId);
    }

    /**
     * @return ProjectId
     */
    public function getProjectId(): ProjectId
    {
        return $this->projectId;
    }
}
