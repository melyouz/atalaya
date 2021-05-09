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
use App\Users\Application\Command\ConfirmUserCommand;
use Symfony\Component\HttpFoundation\Response;

class ConfirmUserController extends AbstractController
{
    public function __invoke(string $token): Response
    {
        $command = new ConfirmUserCommand($token);
        $this->dispatch($command);

        return new Response('', Response::HTTP_OK);
    }
}
