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

namespace App\Users\Presentation\Api\Controller;


use App\Shared\Presentation\Api\Controller\AbstractApiController;
use App\Shared\Presentation\Api\Controller\AbstractController;
use App\Users\Application\Command\EditUserCommand;
use App\Users\Presentation\Api\Input\EditUserInput;
use App\Users\Presentation\Api\Input\RegisterUserInput;
use Symfony\Component\HttpFoundation\Response;

class EditUserController extends AbstractController
{
    public function __invoke(string $id, EditUserInput $input, array $validationErrors): Response
    {
        if (count($validationErrors)) {
            return $this->validationErrorResponse($validationErrors);
        }

        $command = new EditUserCommand($id, $input->name ?? '', $input->email ?? '', $input->password ?? '');
        $this->dispatch($command);

        return new Response('', Response::HTTP_OK);
    }
}
