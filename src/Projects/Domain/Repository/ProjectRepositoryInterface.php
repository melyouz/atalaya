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

namespace App\Projects\Domain\Repository;

use App\Projects\Domain\Exception\ProjectNotFoundException;
use App\Projects\Domain\Model\Project;
use App\Projects\Domain\Model\ProjectId;
use App\Projects\Domain\Model\ProjectToken;
use App\Users\Domain\Model\UserId;

interface ProjectRepositoryInterface
{
    /**
     * @param ProjectId $id
     * @return Project
     * @throws ProjectNotFoundException
     */
    public function get(ProjectId $id): Project;

    /**
     * @param UserId $userId
     * @return array
     */
    public function findAllByUserId(UserId $userId): array;

    /**
     * @param ProjectId $id
     * @param ProjectToken $token
     * @return bool
     */
    public function isProjectTokenValidOrThrow(ProjectId $id, ProjectToken $token): bool;

    /**
     * @param Project $project
     */
    public function save(Project $project): void;
}
