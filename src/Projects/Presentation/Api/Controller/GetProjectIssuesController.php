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

namespace App\Projects\Presentation\Api\Controller;

use App\Projects\Application\Query\GetProjectIssuesQuery;
use App\Shared\Presentation\Api\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetProjectIssuesController extends AbstractController
{
    public function __invoke(string $projectId): Response
    {
        $query = new GetProjectIssuesQuery($projectId);
        $issues = $this->query($query);

        return $this->toJsonResponse($issues);
    }
}
