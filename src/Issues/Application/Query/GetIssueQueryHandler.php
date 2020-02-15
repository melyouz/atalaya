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

namespace App\Issues\Application\Query;

use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Repository\IssueRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

class GetIssueQueryHandler implements QueryHandlerInterface
{
    /**
     * @var IssueRepositoryInterface
     */
    private IssueRepositoryInterface $issueRepo;

    public function __construct(IssueRepositoryInterface $issueRepo)
    {
        $this->issueRepo = $issueRepo;
    }

    public function __invoke(GetIssueQuery $query): Issue
    {
        return $this->issueRepo->get($query->getId());
    }
}
