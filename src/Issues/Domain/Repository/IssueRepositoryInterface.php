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

namespace App\Issues\Domain\Repository;

use App\Issues\Domain\Exception\IssueNotFoundException;
use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Model\Issue\IssueId;
use App\Projects\Domain\Model\Project\ProjectId;

interface IssueRepositoryInterface
{
    /**
     * @throws IssueNotFoundException
     */
    public function get(IssueId $id): Issue;

    public function findAllByProjectId(ProjectId $projectId): array;

    public function save(Issue $issue): void;
}
