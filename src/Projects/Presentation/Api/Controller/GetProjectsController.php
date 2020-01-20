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

use App\Projects\Application\Query\GetProjectsByUserIdQuery;
use App\Shared\Presentation\Api\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetProjectsController extends AbstractController
{
    public function __invoke(): Response
    {
        // @todo: get logged in user_id
        $userId = '988cd824-1689-4bf5-bfa4-f0cc66120276';

        $query = new GetProjectsByUserIdQuery($userId);
        $result = $this->query($query);

        return $this->toJsonResponse($result);
    }
}
