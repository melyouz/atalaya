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

namespace App\Issues\Presentation\Api\Controller;

use App\Issues\Application\Command\UnresolveIssueCommand;
use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Model\IssueId;
use App\Issues\Domain\Repository\IssueRepositoryInterface;
use App\Shared\Presentation\Api\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class UnresolveIssueController extends AbstractController
{
    public function __invoke(string $id, IssueRepositoryInterface $issueRepo): Response
    {
        if (!$this->isGranted(Issue::UNRESOLVE, $issueRepo->get(IssueId::fromString($id)))) {
            return new Response(null, Response::HTTP_UNAUTHORIZED);
        }

        $command = new UnresolveIssueCommand($id);
        $this->dispatch($command);

        return new Response('', Response::HTTP_OK);
    }
}
