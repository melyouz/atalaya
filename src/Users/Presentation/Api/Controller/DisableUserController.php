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
use App\Users\Domain\Model\User;
use App\Users\Domain\Model\User\UserId;
use App\Users\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class DisableUserController extends AbstractController
{
    public function __invoke(string $id, UserRepositoryInterface $userRepo): Response
    {
        if (!$this->isGranted(User::DISABLE, $userRepo->get(UserId::fromString($id)))) {
            return new Response(null, Response::HTTP_UNAUTHORIZED);
        }

        $command = new DisableUserCommand($id);
        $this->dispatch($command);

        return new Response('', Response::HTTP_OK);
    }
}
