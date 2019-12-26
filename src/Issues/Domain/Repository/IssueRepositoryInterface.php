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

namespace App\Issues\Domain\Repository;

use App\Issues\Domain\Exception\IssueNotFoundException;
use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Model\IssueId;
use App\Projects\Domain\Model\ProjectId;

interface IssueRepositoryInterface
{
    /**
     * @param IssueId $id
     * @return Issue
     * @throws IssueNotFoundException
     */
    public function get(IssueId $id): Issue;

    /**
     * @param ProjectId $projectId
     * @return array
     */
    public function findAllByProjectId(ProjectId $projectId): array;

    /**
     * @param Issue $issue
     */
    public function save(Issue $issue): void;
}
