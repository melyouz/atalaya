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

namespace App\Projects\Presentation\Api\Controller;

use App\Projects\Application\Query\GetProjectIssuesQuery;
use App\Projects\Domain\Model\Project;
use App\Projects\Domain\Model\Project\ProjectId;
use App\Projects\Domain\Repository\ProjectRepositoryInterface;
use App\Shared\Presentation\Api\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetProjectIssuesController extends AbstractController
{
    public function __invoke(string $projectId, ProjectRepositoryInterface $projectRepo): Response
    {
        if (!$this->isGranted(Project::LIST_ISSUES, $projectRepo->get(ProjectId::fromString($projectId)))) {
            return new Response(null, Response::HTTP_UNAUTHORIZED);
        }

        $query = new GetProjectIssuesQuery($projectId);
        $issues = $this->query($query);

        return $this->toJsonResponse($issues);
    }
}
