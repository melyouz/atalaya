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

use App\Projects\Application\Command\CreateProjectCommand;
use App\Projects\Presentation\Api\Input\CreateProjectInput;
use App\Shared\Presentation\Api\Controller\AbstractController;
use App\Users\Domain\Model\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateProjectController extends AbstractController
{
    public function __invoke(CreateProjectInput $input, array $validationErrors): Response
    {
        if (count($validationErrors)) {
            return $this->validationErrorResponse($validationErrors);
        }

        /** @var User $user */
        $user = $this->getLoggedInUser();
        $projectId = $this->uuid();

        $command = new CreateProjectCommand($projectId, $input->name, $input->url, $input->platform, $user->getId()->value());
        $this->dispatch($command);

        return new JsonResponse(['id' => $projectId], Response::HTTP_CREATED);
    }
}
