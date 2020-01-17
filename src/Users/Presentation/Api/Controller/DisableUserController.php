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

use App\Shared\Presentation\Api\Controller\AbstractController;
use App\Users\Application\Command\DisableUserCommand;
use Symfony\Component\HttpFoundation\Response;

class DisableUserController extends AbstractController
{
    public function __invoke(string $id): Response
    {
        $command = new DisableUserCommand($id);
        $this->dispatch($command);

        return new Response('', Response::HTTP_OK);
    }
}
