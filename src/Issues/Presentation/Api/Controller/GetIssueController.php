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

use App\Issues\Application\Query\GetIssueQuery;
use App\Shared\Presentation\Api\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetIssueController extends AbstractController
{
    public function __invoke(string $id): Response
    {
        $query = new GetIssueQuery($id);
        $issue = $this->query($query);

        return $this->toJsonResponse($issue);
    }
}
