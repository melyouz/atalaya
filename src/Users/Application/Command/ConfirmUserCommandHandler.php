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

namespace App\Users\Application\Command;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Users\Domain\Repository\UserRepositoryInterface;

class ConfirmUserCommandHandler implements CommandHandlerInterface
{
    private UserRepositoryInterface $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function __invoke(ConfirmUserCommand $command): void
    {
        $user = $this->userRepo->getByToken($command->getToken());
        $user->confirm();
        $this->userRepo->save($user);
    }
}
