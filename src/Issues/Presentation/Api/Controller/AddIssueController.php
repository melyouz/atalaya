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

use App\Issues\Application\Command\AddIssueCommand;
use App\Issues\Presentation\Api\Input\AddIssueInput;
use App\Shared\Presentation\Api\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AddIssueController extends AbstractController
{
    private ?string $projectId;
    private ?string $projectToken;

    public function __invoke(Request $request, AddIssueInput $input, array $validationErrors): Response
    {
        if (count($validationErrors)) {
            return $this->validationErrorResponse($validationErrors);
        }

        $this->handleRequest($request);

        if (empty($this->projectId) || empty($this->projectToken)) {
            return new Response('', Response::HTTP_UNAUTHORIZED);
        }

        $issueId = $this->uuid();
        $exception = $input->exception->toDomainObject();
        $request = $input->request->toDomainObject();
        $command = new AddIssueCommand($issueId, $this->projectId, $this->projectToken, $exception, $request, $input->tags);
        $this->dispatch($command);

        return new JsonResponse(['id' => $issueId], Response::HTTP_CREATED);
    }

    private function handleRequest(Request $request): void
    {
        $this->projectId = $request->getUser();
        $this->projectToken = $request->getPassword();
    }
}
