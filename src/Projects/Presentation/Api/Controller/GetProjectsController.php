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

use App\Projects\Application\Query\GetProjectsByUserIdQuery;
use App\Shared\Presentation\Api\Controller\AbstractController;
use App\Users\Domain\Model\User;
use Symfony\Component\HttpFoundation\Response;

class GetProjectsController extends AbstractController
{
    public function __invoke(): Response
    {
        /** @var User $user */
        $user = $this->getLoggedInUser();

        $query = new GetProjectsByUserIdQuery($user->getId()->value());
        $result = $this->query($query);

        return $this->toJsonResponse($result);
    }
}
