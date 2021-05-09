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

namespace App\Issues\Presentation\Api\Controller;

use App\Issues\Application\Command\PinIssueCommand;
use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Model\Issue\IssueId;
use App\Issues\Domain\Repository\IssueRepositoryInterface;
use App\Shared\Presentation\Api\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PinIssueController extends AbstractController
{
    public function __invoke(string $id, IssueRepositoryInterface $issueRepo): Response
    {
        if (!$this->isGranted(Issue::RESOLVE, $issueRepo->get(IssueId::fromString($id)))) {
            return new Response(null, Response::HTTP_UNAUTHORIZED);
        }

        $command = new PinIssueCommand($id);
        $this->dispatch($command);

        return new Response('', Response::HTTP_OK);
    }
}
