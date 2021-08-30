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

namespace App\Projects\Application\Query;

use App\Issues\Domain\Repository\IssueRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

class GetProjectIssuesQueryHandler implements QueryHandlerInterface
{
    private IssueRepositoryInterface $issueRepo;

    public function __construct(IssueRepositoryInterface $issueRepo)
    {
        $this->issueRepo = $issueRepo;
    }

    public function __invoke(GetProjectIssuesQuery $query): array
    {
        return $this->issueRepo->findAllByProjectId($query->getProjectId());
    }
}
