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

namespace App\Projects\Domain\Repository;

use App\Projects\Domain\Exception\ProjectNotFoundException;
use App\Projects\Domain\Model\Project;
use App\Projects\Domain\Model\Project\ProjectId;
use App\Projects\Domain\Model\Project\ProjectToken;
use App\Users\Domain\Model\User\UserId;

interface ProjectRepositoryInterface
{
    /**
     * @throws ProjectNotFoundException
     */
    public function get(ProjectId $id): Project;

    public function findAllByUserId(UserId $userId): array;

    public function isProjectTokenValidOrThrow(ProjectId $id, ProjectToken $token): bool;

    public function save(Project $project): void;
}
