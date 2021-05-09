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

namespace App\Users\Presentation\Api\Controller;

use App\Shared\Presentation\Api\Controller\AbstractController;
use App\Users\Application\Command\RegisterUserCommand;
use App\Users\Presentation\Api\Input\RegisterUserInput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RegisterUserController extends AbstractController
{
    public function __invoke(RegisterUserInput $input, array $validationErrors): Response
    {
        if (count($validationErrors)) {
            return $this->validationErrorResponse($validationErrors);
        }

        $userId = $this->uuid();
        $command = new RegisterUserCommand($userId, $input->name, $input->email, $input->password);
        $this->dispatch($command);

        return new JsonResponse(['id' => $userId], Response::HTTP_CREATED);
    }
}
