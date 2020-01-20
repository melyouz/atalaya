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

use App\Projects\Domain\Repository\ProjectRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

class GetProjectsByUserIdQueryHandler implements QueryHandlerInterface
{
    /**
     * @var ProjectRepositoryInterface
     */
    private ProjectRepositoryInterface $projectRepo;

    public function __construct(ProjectRepositoryInterface $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    public function __invoke(GetProjectsByUserIdQuery $query): array
    {
        return $this->projectRepo->findAllByUserId($query->getUserId());
    }
}
