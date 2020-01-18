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

use App\Issues\Domain\Repository\IssueRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

class UnresolveIssueCommandHandler implements CommandHandlerInterface
{
    /**
     * @var IssueRepositoryInterface
     */
    private IssueRepositoryInterface $issueRepo;

    public function __construct(IssueRepositoryInterface $issueRepo)
    {
        $this->issueRepo = $issueRepo;
    }

    public function __invoke(UnresolveIssueCommand $command)
    {
        $issue = $this->issueRepo->get($command->getId());
        $issue->unresolve();
        $this->issueRepo->save($issue);
    }
}
